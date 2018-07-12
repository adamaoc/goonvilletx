import React from 'react';

class EditSponsors extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      sponsors: [],
      newSponsor: {
        name: '',
        link: '',
        image: '',
        image_alt: '',
        placement: '',
        color: ''
      }
    }
  }
  componentDidMount() {
    const { pathname, host } = window.location;
    const apiUrl = (host === 'goonvilletx.com') ? 'http://goonvilletx.com/api' : 'http://localhost:8888/api';
    const fetchUrl = apiUrl + '/sponsors/';
    const games = fetch(
      fetchUrl,
      {
        headers: {
          Token: window.token
        }
      }
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({ sponsors: resp.sponsors });
    });
  }
  updateData(field, value) {
    const { newSponsor } = this.state;
    newSponsor[field] = value;
    this.setState({ newSponsor });
  }
  upload() {
    const { newSponsor } = this.state;
    const { host } = window.location;
    const apiUrl = (host === 'goonvilletx.com') ? 'http://goonvilletx.com/api' : 'http://localhost:8888/api';
    const fetchUrl = apiUrl + '/sponsors/';
    const games = fetch(
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
      console.log(resp);
      window.location.reload();
    });
  }
  render() {
    return (
      <div>
        Sponsors
        <div>
          <h3>Current Sponsors</h3>
          {this.state.sponsors.map((sponsor) => {
            return <img src={`/public/images/sponsors/${sponsor.image}`} width="150px" key={sponsor.id} />
          })}
        </div>
        <div>
          <h3>Add Sponsor</h3>
          <input type="text" placeholder="Company Name" onChange={(e) => {this.updateData('name', e.target.value)}} />
          <input type="text" placeholder="Image File Name" onChange={(e) => {this.updateData('image', e.target.value)}} />
          <input type="text" placeholder="Image Alt Text" onChange={(e) => {this.updateData('image_alt', e.target.value)}} />
          <input type="text" placeholder="Company Website" onChange={(e) => {this.updateData('link', e.target.value)}} />
          <input type="text" placeholder="Website Placement" onChange={(e) => {this.updateData('placement', e.target.value)}} />
          <input type="text" placeholder="Hex Color" onChange={(e) => {this.updateData('color', e.target.value)}} />
          <button onClick={() => this.upload()}>Upload</button>
        </div>
      </div>
    )
  }
}

export default EditSponsors;
