import React from 'react';
import styled from 'styled-components';

const Input = styled.input`
  font-size: 1rem;
  padding: 0.25rem 0.5rem;
`;

const AdminSection = styled.div`
  background: #eaeaea;
  border: 1px solid #c1c1c1;
  padding: 1em;
  margin-bottom: 1em;
  section {
    display: flex;
    justify-content: stretch;
    align-items: stretch;
  }
  h5 {
    margin-left: 18px;
    margin-bottom: 5px;
  }
`;

const FormGroup = styled.div`
  border: 1px dashed #888;
  padding: 1em;
  margin: 0 1em 1em;
  flex: 1;
  background: #fff;
  label {
    display: block;
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #a7a7a7;
    padding-left: 0.5rem;
    font-weight: bold;
    letter-spacing: 1px;
  }
  input {
    margin-bottom: 1em;
    width: 100%;
  }
`;

class EditHomePage extends React.Component {
  constructor(props) {
    super(props);

    let seoDescription;
    const metas = document.getElementsByTagName('meta');
    for (let i = 0; i < metas.length; i++) {
      if (metas[i].name === 'description') {
        seoDescription = metas[i];
      }
    }
    this.state = {
      pageData: {},
      pageTitle: document.querySelector('.large-banner__content').querySelector('h1'),
      actionLink: document.querySelector('.large-banner__content').querySelector('a'),
      seoTitle: document.querySelector('title'),
      seoDescription
    }
  }
  componentDidMount() {
    const games = fetch(
      'http://localhost:8888/api/page/home/',
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
    console.log(pageData);
    const games = fetch(
      'http://localhost:8888/api/page/home/',
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify([pageData])
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
    console.log(pageData);
  }

  render() {
    const { pageData } = this.state;
    console.log(pageData);
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
            <FormGroup>
              <label>Action Button Text</label>
              <Input type="text" defaultValue={pageData.action_btn_text} onChange={(e) => { this.updateData('action_btn_text', e.currentTarget.value)}} />
              <br />
              <label>Action Button Link</label>
              <Input type="text" defaultValue={pageData.action_btn_link} onChange={(e) => { this.updateData('action_btn_link', e.currentTarget.value)}} />
            </FormGroup>
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
        <button onClick={() => {
            this.updatePage();
          }}>Update</button>
      </div>
    )
  }
}

export default EditHomePage;
