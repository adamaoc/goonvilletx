import React from 'react';
import styled from 'styled-components';
import { Button } from './lib/Buttons';
import { Input } from './lib/Forms';
import {
  PushRight,
  AdminSection,
  FormGroup
} from './lib/Layouts';



class EditHomePage extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      pageData: {}
    }
  }
  componentDidMount() {
    const { pathname, host } = window.location;
    let pagePath = pathname;
    if (pathname === '/') {
      pagePath = '/home'
    }
    let apiUrl = 'http://goonvilletx.com/api';
    if (host !== 'goonvilletx.com') {
      apiUrl = 'http://localhost:8888/api';
    }
    const fetchUrl = apiUrl + '/page' + pagePath;
    console.log(fetchUrl);
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
      this.setState({ pageData: resp.page[0] });
    });
  }

  updatePage() {
    const { pageData } = this.state;
    const { pathname, host } = window.location;
    let pagePath = (pathname === '/') ? 'home' : pathname.split('/')[1];
    let apiUrl = 'http://goonvilletx.com/api/page/update/';
    if (host !== 'goonvilletx.com') {
      apiUrl = 'http://localhost:8888/api/page/update/';
    }
    const fetchUrl = apiUrl + '?page=' + pagePath;
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

  render() {
    const { pageData } = this.state;
    return (
      <div>
        <h4>Editing Home Page!</h4>
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
            }}>Update</Button>
        </PushRight>
      </div>
    )
  }
}

export default EditHomePage;
