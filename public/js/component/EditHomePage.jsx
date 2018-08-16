import React from 'react';
import styled from 'styled-components';
import { Button } from './lib/Buttons';
import { Input } from './lib/Forms';
import {
  PushRight,
  AdminSection,
  FormGroup,
  FlexGroup
} from './lib/Layouts';
import { APIURL } from '../constants/AppConstants';


const FormGroupEdit = ({ field, value, handleChange }) => {
  return (
    <React.Fragment>
      <label htmlFor="page-title">{field}</label>
      <Input type="text"
        defaultValue={value}
        autoComplete="off"
        onChange={(e) => handleChange(field, e.target.value)}
      />
    </React.Fragment>
  )
}
const SchoolAddress = ({ address, handleAddressChange }) => {
  const addressFields = ['street', 'city', 'state', 'zip'];
  return (
    <FormGroup>
      {addressFields.map((field, i) => {
        return <FormGroupEdit key={i} field={field}
                              value={address[field]}
                              handleChange={handleAddressChange} />
      })}
    </FormGroup>
  )
}
const SchoolInfo = ({ info, handleInfoChange }) => {
  const infoFields = ['school_name', 'phone', 'email', 'mascot'];
  return (
    <FormGroup>
      {infoFields.map((field, i) => {
        return <FormGroupEdit key={i} field={field}
                              value={info[field]}
                              handleChange={handleInfoChange} />
      })}
    </FormGroup>
  )
}
const SocialInfo = ({ info, handleSocialChange }) => {
  const infoFields = ['twitter', 'facebook'];
  return (
    <FormGroup>
      {infoFields.map((field, i) => {
        return <FormGroupEdit key={i} field={field}
                              value={info[field]}
                              handleChange={handleSocialChange} />
      })}
    </FormGroup>
  )
}

class EditHomePage extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      pageData: {},
      replaceImg: null,
      schoolInfo: {
        address: null
      },
      pagePath: (window.location.pathname === '/') ? 'home' : window.location.pathname.split('/')[1]
    }
  }
  componentDidMount() {
    const fetchUrl = APIURL + '/page/' + this.state.pagePath;
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
      this.setState({
        pageData: resp.page[0],
        schoolInfo: resp.page.school
      });
    });
  }

  updatePage() {
    const { pageData } = this.state;
    const fetchUrl = APIURL + '/page/update/?page=' + this.state.pagePath;
    const games = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(pageData)
      }
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({ pageData: resp.page });
      window.location.reload();
    });
  }

  updateData(field, value) {
    let { pageData } = this.state;
    pageData[field] = value;
    this.setState({ pageData });
  }

  updateSchoolInfo(field, value) {
    let { schoolInfo } = this.state;
    schoolInfo[field] = value;
    this.setState({ schoolInfo });
  }
  updateSchoolAddress(field, value) {
    let { schoolInfo } = this.state;
    schoolInfo.address[field] = value;
    this.setState({ schoolInfo });
  }
  postSchoolDetails() {
    const { schoolInfo } = this.state;
    const updatedData = fetch(
      `${APIURL}/school/update/`,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(schoolInfo)
      }
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({ schoolInfo: resp.school });
      window.location.reload();
    });
  }

  replaceLogoImg(e) {
    const { replaceImg } = this.state;
    const img = e.target.files[0];
    if (img) {
      let formData = new FormData();
      formData.append('file', img);
      const fetchUrl = `${APIURL}/school/logo-upload?location=${replaceImg}`;
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
        this.setState({
          schoolInfo: resp.school
        });
      });
    }
  }

  render() {
    const { pageData, pagePath, schoolInfo } = this.state;
    const addressFields = ['street', 'city', 'state', 'zip'];
    let fileInput = null;

    return (
      <div>
        <h2>Editing {pagePath} Page!</h2>
        <AdminSection>
          <h5>Edit Header Info.</h5>
          <section>
            <FormGroup>
              <label htmlFor="page-title">Page Title: </label>
              <Input type="text" defaultValue={pageData.page_title} autoComplete="off" onChange={(e) => { this.updateData('page_title', e.currentTarget.value)}} />
            </FormGroup>
            {pageData.action_btn_link !== 'null'
              ? (
                <FormGroup>
                  <label>Action Button Text</label>
                  <Input type="text" defaultValue={pageData.action_btn_text} onChange={(e) => { this.updateData('action_btn_text', e.currentTarget.value)}} />
                  <br />
                  <label>Action Button Link</label>
                  <Input type="text" defaultValue={pageData.action_btn_link} onChange={(e) => { this.updateData('action_btn_link', e.currentTarget.value)}} />
                </FormGroup>
              )
              : null
            }
          </section>
        </AdminSection>

        <AdminSection>
          <h5>Page SEO</h5>
          <section>
            <FormGroup>
              <label>SEO Title</label>
              <Input type="text" defaultValue={pageData.seo_title} autoComplete="off" onChange={(e) => { this.updateData('seo_title', e.currentTarget.value)}} />
            </FormGroup>
            <FormGroup>
              <label>SEO Description</label>
              <Input type="text" defaultValue={pageData.seo_desc} autoComplete="off" onChange={(e) => { this.updateData('seo_desc', e.currentTarget.value)}} />
            </FormGroup>
          </section>
        </AdminSection>
        <PushRight>
          <Button primary onClick={() => {
              this.updatePage();
            }}>Update {pagePath} Page</Button>
        </PushRight>

        <h2>Edit School Details</h2>
        <AdminSection>
          <section>
            <SchoolInfo info={schoolInfo} handleInfoChange={this.updateSchoolInfo.bind(this)} />
            <SchoolAddress address={schoolInfo} handleAddressChange={this.updateSchoolAddress.bind(this)} />
          </section>
          <section>
            <SocialInfo info={schoolInfo} handleSocialChange={this.updateSchoolInfo.bind(this)} />
            <FormGroup>
              <div style={{display: 'none'}}>
                <input
                  type="file"
                  onChange={this.replaceLogoImg.bind(this)}
                  style={{display: 'none'}}
                  ref={fi => fileInput = fi} />
              </div>
              <div>
                <label>Header Logo</label>
                <FlexGroup>
                  <img src={schoolInfo.header_logo} height="50px" />
                  <Button onClick={() => {
                    this.setState({replaceImg: 'header_logo'});
                    fileInput.click();
                  }}>Replace</Button>
                </FlexGroup>
              </div>
              <div>
                <label>Footer Logo</label>
                <FlexGroup>
                  <img src={schoolInfo.footer_logo} height="50px" />
                  <Button onClick={() => {
                    this.setState({replaceImg: 'footer_logo'});
                    fileInput.click();
                  }}>Replace</Button>
                </FlexGroup>
              </div>
            </FormGroup>
          </section>
        </AdminSection>
        <PushRight>
          <Button primary onClick={() => {
              this.postSchoolDetails();
            }}>Update School Details</Button>
        </PushRight>
      </div>
    )
  }
}

export default EditHomePage;
