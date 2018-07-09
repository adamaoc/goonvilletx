import React from 'react';

const editPaneStyle = {
  position: 'fixed',
  top: '30px',
  left: '0',
  right: '0',
  background: 'white',
  padding: '1em',
  zIndex: '100'
}
const adminBarStyle = {
  position: 'fixed',
  left: '0',
  right: '0',
  top: '0',
  background: '#333',
  color: '#fff',
  height: '30px',
  display: 'flex',
  alignItems: 'center'
}

class App extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      path: window.location.pathname,
      paneOpen: false
    }
  }
  componentDidMount() {
    document.body.style.marginTop = "30px";
    document.querySelector('.site-header').style.marginTop = "30px";
  }
  logout() {
    window.localStorage.removeItem('login');
    document.body.style.marginTop = "0";
    document.querySelector('.site-header').style.marginTop = "0";
  }
  editPage() {
    const { path } = this.state;
    switch (path) {
      case '/':
        this.setState({editingPage: 'home', paneOpen: true});
        break;
      case '/about':
        this.setState({editingPage: 'about', paneOpen: true});
      default:
        this.setState({editingPage: 'admin', paneOpen: true});
    }
  }
  render() {
    return (
      <div className="admin-app">
        <div style={adminBarStyle}>
          <button onClick={() => this.editPage()}>Edit Page</button>
          <button>Edit Schedule</button>
          <button onClick={this.logout}>Logout</button>
          <div className="admin-bar__user">
            Welcome, {this.props.user.fullname}
          </div>
        </div>
        {this.state.paneOpen
          ? <div style={editPaneStyle}>Hello</div>
          : null
        }
      </div>
    )
  }
}

export default App;
