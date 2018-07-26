import React from 'react';
import styled from 'styled-components';
import { Table } from './lib/Tables';
import { Loading } from './lib/Loading';
import {
  UploadImgBtn,
  Button,
  DissabledBtn,
  SVGButton
} from './lib/Buttons';
import { APIURL } from '../constants/AppConstants';


const ActionButtons = ({update, remove}) => {
  return (
    <React.Fragment>
      <Button onClick={update}>Update</Button>
      <SVGButton onClick={remove}><svg viewBox="0 0 32 32" width="15px" height="15px">
    <path d="M25 4h-18c-1.657 0-3 1.343-3 3v1h24v-1c0-1.657-1.343-3-3-3zM19.76 2l0.441 3.156h-8.402l0.441-3.156h7.52zM20 0h-8c-0.825 0-1.593 0.668-1.708 1.486l-0.585 4.185c-0.114 0.817 0.467 1.486 1.292 1.486h10c0.825 0 1.407-0.668 1.292-1.486l-0.585-4.185c-0.114-0.817-0.883-1.486-1.708-1.486v0zM25.5 10h-19c-1.1 0-1.918 0.896-1.819 1.992l1.638 18.016c0.1 1.095 1.081 1.992 2.181 1.992h15c1.1 0 2.081-0.896 2.181-1.992l1.638-18.016c0.1-1.095-0.719-1.992-1.819-1.992zM12 28h-3l-1-14h4v14zM18 28h-4v-14h4v14zM23 28h-3v-14h4l-1 14z"></path>
  </svg></SVGButton>
    </React.Fragment>
  )
}

const FileUploadForm = ({uploadImg}) => {
  let fileInput = null;
  return (
    <div>
      <input
        type="file"
        onChange={uploadImg}
        style={{display: 'none'}}
        ref={fi => fileInput = fi}
      />
      <UploadImgBtn onClick={() => fileInput.click()}>Upload</UploadImgBtn>
    </div>
  )
}

const PlacementCheckbox = ({placement, handleChange, id}) => {
  let isHome = false;
  if (placement === 'home') {
    isHome = true;
  }
  return (
    <div>
      <input type="checkbox" checked={isHome} id={`placement-${id}`} onChange={handleChange} /> {" "}
      <label htmlFor={`placement-${id}`}>Show on Home Page?</label>
    </div>
  )
}

class EditSponsors extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      sponsors: [],
      newSponsorsAdded: false,
      loading: true,
      newSponsor: {
        name: '',
        link: '#',
        image: '',
        image_alt: '',
        placement: '',
        color: '#eee'
      }
    }
  }
  componentDidMount() {
    const fetchUrl = APIURL + '/sponsors/';
    const sponsors = fetch(
      fetchUrl,
      {
        headers: {
          Token: window.token
        }
      }
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      setTimeout(() => {
        this.setState({
          loading: false,
          sponsors: resp.sponsors
        });
      }, 300);
    });
  }
  componentWillUnmount() {
    if (this.state.newSponsorsAdded) {
      window.location.reload();
    }
  }
  updateData(field, value) {
    const { newSponsor } = this.state;
    newSponsor[field] = value;
    this.setState({ newSponsor });
  }
  updateSponsor(id, field, value) {
    const { sponsors } = this.state;
    sponsors.forEach((sponsor) => {
      if (sponsor.id === id) {
        sponsor[field] = value;
      }
    });
    this.setState({ sponsors });
  }
  addSponsor() {
    let { newSponsor } = this.state;
    const fetchUrl = APIURL + '/sponsors/add/';
    const sponsors = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(newSponsor)
      }
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({
        sponsors: resp.sponsors,
        newSponsor: {
          name: '',
          link: '#',
          image: '',
          image_alt: '',
          placement: '',
          color: '#eee'
        },
        tempImg: null,
        newSponsorsAdded: true
      });
    });
  }
  uploadImg(e) {
    const img = e.target.files[0];
    if (img) {
      let formData = new FormData();
      formData.append('file', img);
      const fetchUrl = APIURL + '/sponsors/upload/';
      const file = fetch(
        fetchUrl,
        {
          method: 'post',
          headers: {
            Token: window.token
          },
          body: formData
        }
      ).then((resp) => {
        return resp.json();
      }).then((resp) => {
        let updatedSponsor = this.state.newSponsor;
        updatedSponsor.image = resp.image.file_name;
        this.setState({
          tempImg: resp.image.file_path,
          newSponsor: updatedSponsor
        })
      });
    }
  }
  updateRow(id) {
    const {sponsors} = this.state;
    let sponsor = sponsors.filter((s) => s.id === id);
    const fetchUrl = APIURL + '/sponsors/update';
    this.setState({loading: true});
    const newSpon = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(sponsor)
      }
    ).then((resp) => { return resp.json()}).then((resp) => {
      sponsors.forEach((s) => {
        if (s.id === resp.sponsor.id) {
          s = resp.sponsor;
        }
      })

      setTimeout(() => {
        this.setState({
          loading: false,
          sponsors
        });
      }, 300);
      // this.setState({
      //   loading: false,
      //   sponsors
      // });
    })
  }
  removeRow(id) {
    const {sponsors} = this.state;
    let newSponsors = sponsors.filter((s) => s.id !== id);
    const fetchUrl = APIURL + '/sponsors/delete?id=' + id;
    const newSpon = fetch(
      fetchUrl,
      {
        method: 'delete',
        headers: {
          Token: window.token
        }
      }
    ).then((resp) => { return resp.json()}).then((resp) => {
      if (resp.error) {
        // handle error //
      } else {
        this.setState({ sponsors: newSponsors });
      }
    })
  }
  render() {
    const { newSponsor } = this.state;
    let newSponsorId = null;
    if (this.state.sponsors.length > 0) {
      newSponsorId = (parseInt(this.state.sponsors[(this.state.sponsors.length -1)].id) + 1);
    }
    let enableAdd = false;
    if (this.state.tempImg) {
      enableAdd = true;
    }
    return (
      <div>
        <h2>Sponsors</h2>
        <div style={{position: 'relative'}}>
          <Table>
            <thead>
              <tr>
                <td>Sponsor ID</td>
                <td>Image</td>
                <td>Alt Text</td>
                <td>Company Name</td>
                <td>Site Placement</td>
                <td className="center"> -- </td>
              </tr>
            </thead>
            <tbody>
              {this.state.sponsors.map((sponsor) => {
                return (
                  <tr key={sponsor.id}>
                    <td className="center">{sponsor.id}</td>
                    <td><img src={`/public/images/sponsors/${sponsor.image}`} width="50px" /></td>
                    <td className="editable">
                      <input type="text" defaultValue={sponsor.image_alt} onChange={(e) => {this.updateSponsor(sponsor.id, 'image_alt', e.target.value)}} />
                    </td>
                    <td className="editable">
                      <input type="text" defaultValue={sponsor.name} onChange={(e) => {this.updateSponsor(sponsor.id, 'name', e.target.value)}} />
                    </td>
                    <td className="editable">
                      <PlacementCheckbox
                        id={sponsor.id}
                        handleChange={(e) => {
                          let value = 'site';
                          if (e.target.checked) {
                            value = 'home';
                          }
                          this.updateSponsor(sponsor.id, 'placement', value)
                        }}
                        placement={sponsor.placement}
                      />
                    </td>
                    <td className="center">
                      <ActionButtons
                        update={this.updateRow.bind(this, sponsor.id)}
                        remove={this.removeRow.bind(this, sponsor.id)} />
                    </td>
                  </tr>
                )
              })}
              <tr>
                <td className="center">
                  {newSponsorId}
                </td>
                <td>
                  {
                    this.state.tempImg
                    ? <img src={this.state.tempImg} width="50px" />
                    : <FileUploadForm uploadImg={this.uploadImg.bind(this)} />
                  }
                </td>
                <td className="editable">
                  <input type="text" placeholder="Image Alt Text" value={newSponsor.image_alt} onChange={(e) => {this.updateData('image_alt', e.target.value)}} />
                </td>
                <td className="editable">
                  <input type="text" placeholder="Company Name" value={newSponsor.name} onChange={(e) => {this.updateData('name', e.target.value)}} />
                </td>
                <td className="editable">
                  <PlacementCheckbox
                    id={newSponsor.id}
                    handleChange={(e) => {
                      let value = 'site';
                      if (e.target.checked) {
                        value = 'home';
                      }
                      this.updateData('placement', value)
                    }}
                    placement={newSponsor.placement}
                  />
                </td>
                <td className="center">
                  <Button disabled={!enableAdd} primary onClick={() => this.addSponsor()}>+ Add Sponsor</Button>
                </td>
              </tr>
            </tbody>
          </Table>
          {this.state.loading
            ? <Loading>Loading...</Loading>
            : null
          }
        </div>
      </div>
    )
  }
}

export default EditSponsors;
