import React from 'react';
import styled from 'styled-components';
import EditHomePage from './EditHomePage';
import EditSchedule from './EditSchedule';

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
      path: window.location.pathname,
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
    window.location = window.location.href + '/admin/logout/';
  }
  editPage() {
    const { path, paneOpen, editingPage } = this.state;
    if (paneOpen && editingPage === path) {
      document.body.style.overflow = 'auto';
      this.setState({ paneOpen: false });
      return;
    }
    document.body.style.overflow = 'hidden';
    switch (path) {
      case '/':
        this.setState({editingPage: '/', paneOpen: true});
        break;
      case '/about':
        this.setState({editingPage: 'about', paneOpen: true});
      default:
        this.setState({editingPage: 'admin', paneOpen: true});
    }
  }
  renderEditingPage(page) {
    switch (page) {
      case '/':
        return <EditHomePage />
      case 'schedule':
        return <EditSchedule />
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
  render() {
    return (
      <div className="admin-app">
        <AdminBar>
          <button onClick={() => this.editPage()} style={adminBarBtnStyles}>Edit Page</button>
          <button style={adminBarBtnStyles} onClick={() => this.editSchedule()}>Edit Schedule</button>

          <div style={adminBarUserStyles}>
            Welcome, {this.props.user.fullname}
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
