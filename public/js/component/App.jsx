import React from 'react';
import styled from 'styled-components';
import EditPage from './EditPage';
import EditSchedule from './EditSchedule';
import EditSponsors from './EditSponsors';
import EditRosters from './EditRosters';
import EditRadioPosts from './RadioEditor/EditRadioPosts';

const EditPane = styled.div`
  position: fixed;
  top: 30px;
  left: 0;
  right: 0;
  bottom: 0;
  background: #eee;
  padding: 1em;
  z-index: 100;
  overflow-x: auto;
  .schedule-list__icon {
    text-decoration: none;
  }
`;
const AdminBar = styled.div`
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: #333;
  color: #fff;
  height: 30px;
  display: flex;
  align-items: center;
`;
const adminBarUserStyles = {
  marginLeft: 'auto'
}
const adminBarBtnStyles = {
  background: '#444',
  border: '1px solid #555',
  color: '#fff',
  cursor: 'pointer',
  margin: '0 1em',
  fontSize: '14px'
}

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      paneOpen: false,
      editingPage: 'home'
    }
  }
  componentDidMount() {
    document.body.style.marginTop = "30px";
    document.querySelector('.site-header').style.marginTop = "30px";
  }
  logout() {
    document.body.style.marginTop = "0";
    document.querySelector('.site-header').style.marginTop = "0";
    window.location = 'http://' + window.location.host + '/admin/logout/';
  }
  editPage() {
    const { paneOpen, editingPage } = this.state;
    if (paneOpen && editingPage === 'editPage') {
      document.body.style.overflow = 'auto';
      this.setState({ paneOpen: false });
      return;
    }
    document.body.style.overflow = 'hidden';
    this.setState({editingPage: 'editPage', paneOpen: true});
  }
  renderEditingPage(page) {
    switch (page) {
      case 'editPage':
        return <EditPage />
      case 'schedule':
        return <EditSchedule />
      case 'sponsors':
        return <EditSponsors />
      case 'rosters':
        return <EditRosters />
      case 'radio':
        return <EditRadioPosts />
      default:
    }
  }
  editSchedule() {
    const { path, paneOpen, editingPage } = this.state;
    if (paneOpen && editingPage === 'schedule') {
      document.body.style.overflow = 'auto';
      this.setState({ paneOpen: false });
      return;
    }
    document.body.style.overflow = 'hidden';
    this.setState({editingPage: 'schedule', paneOpen: true});
  }
  editSponsors() {
    const { path, paneOpen, editingPage } = this.state;
    if (paneOpen && editingPage === 'sponsors') {
      document.body.style.overflow = 'auto';
      this.setState({ paneOpen: false });
      return;
    }
    document.body.style.overflow = 'hidden';
    this.setState({editingPage: 'sponsors', paneOpen: true});
  }
  editRosters() {
    const { path, paneOpen, editingPage } = this.state;
    if (paneOpen && editingPage === 'rosters') {
      document.body.style.overflow = 'auto';
      this.setState({ paneOpen: false });
      return;
    }
    document.body.style.overflow = 'hidden';
    this.setState({editingPage: 'rosters', paneOpen: true});
  }
  editRadioPosts() {
    const { paneOpen, editingPage } = this.state;
    if (paneOpen && editingPage === 'radio') {
      document.body.style.overflow = 'auto';
      this.setState({paneOpen: false});
      return;
    }
    document.body.style.overflow = 'hidden';
    this.setState({editingPage: 'radio', paneOpen: true});
  }
  editablePage() {
    const whitelisted = ['/', '/schedule', '/about', '/radio'];
    return whitelisted.includes(window.location.pathname);
  }
  render() {
    return (
      <div className="admin-app">
        <AdminBar>
          {this.editablePage()
            ? <button onClick={() => this.editPage()} style={adminBarBtnStyles}>Edit Page</button>
            : null
          }
          <button style={adminBarBtnStyles} onClick={() => this.editSchedule()}>Edit Schedule</button>
          <button style={adminBarBtnStyles} onClick={() => this.editSponsors()}>Edit Sponsors</button>
          <button style={adminBarBtnStyles} onClick={() => this.editRosters()}>Edit Rosters</button>
          <button style={adminBarBtnStyles} onClick={() => this.editRadioPosts()}>Radio Posts</button>

          <div style={adminBarUserStyles}>
            Welcome, <a href={`http://${window.location.host}/admin/`} style={{color: '#eee'}}>{this.props.user.fullname}</a>
            <button onClick={this.logout} style={adminBarBtnStyles}>Logout</button>
          </div>
        </AdminBar>
        {this.state.paneOpen
          ? <EditPane>{this.renderEditingPage(this.state.editingPage)}</EditPane>
          : null
        }
      </div>
    )
  }
}

export default App;
