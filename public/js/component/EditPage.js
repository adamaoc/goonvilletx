import React, { Component } from 'react';
import SchoolEditor from './SchoolEditor/';
import PageEditor from './PageEditor/';
import AnnouncementsEditor from './PageEditor/AnnouncementsEditor';
import { APIURL } from '../constants/AppConstants';

export const PageContext = React.createContext();

class PageProvider extends Component {
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
  updateSchoolInfo(field, value) {
    let { schoolInfo } = this.state;
    schoolInfo[field] = value;
    this.setState({ schoolInfo });
  }
  updateSchoolAddress(field, value) {
    let { schoolInfo } = this.state;
    schoolInfo[field] = value;
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
  updateData(field, value) {
    let { pageData } = this.state;
    pageData[field] = value;
    this.setState({ pageData });
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
  replaceImg(logo) {
    this.setState({
      replaceImg: logo
    })
  }
  render() {
    return (
      <PageContext.Provider value={{
          state: this.state,
          updateSchoolInfo: this.updateSchoolInfo.bind(this),
          updateSchoolAddress: this.updateSchoolAddress.bind(this),
          postSchoolDetails: this.postSchoolDetails.bind(this),
          updateData: this.updateData.bind(this),
          updatePage: this.updatePage.bind(this),
          replaceLogoImg: this.replaceLogoImg.bind(this),
          replaceImg: this.replaceImg.bind(this)
        }}>
        {this.props.children}
      </PageContext.Provider>
    )
  }
}

class EditPage extends Component {
  render() {
    return (
      <PageProvider>
        <PageEditor />
        {window.location.pathname === '/'
          ? <SchoolEditor />
          : null
        }
        {window.location.pathname === '/'
          ? <AnnouncementsEditor />
          : null
        }
      </PageProvider>
    );
  }
}

export default EditPage;
