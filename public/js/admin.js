import PageEditor from './components/PageEditor';

// base admin bar //
var showAdmin = {
  init: function() {
    console.log('login admin');
    this.paneOpen = false;
    document.body.style.marginTop = "30px";
    document.getElementsByClassName('site-header')[0].style.marginTop = "30px";
    var adminNav = document.getElementById('adminNav');
    this.renderBar();
  },
  renderBar: function() {
    adminNav.innerHTML = `<div class="admin-bar">
                            <button onclick="showAdmin.editPage()">Edit Page</button>
                            <button>Edit Schedule</button>
                            <button onclick="showAdmin.logout()">Logout</button>
                          </div>`;
  },
  logout: function() {
    window.localStorage.removeItem('login');
    this.removeAdmin();
  },
  removeAdmin: function() {
    document.body.style.marginTop = "0";
    document.getElementsByClassName('site-header')[0].style.marginTop = "0";
    adminNav.innerHTML = '';
  },
  removePane: function() {
    this.paneOpen = false;
  },
  editPage: function() {
    var path = window.location.pathname;
    switch (path) {
      case '/':
        if (!this.paneOpen) {
          this.paneOpen = true;
          PageEditor.init('home');
        }
        break;
      default:
        PageEditor.init(path);
    }
  }
}

import React from './lib/react';
import ReactDOM from './lib/react-dom';


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
        </div>
        {this.state.paneOpen
          ? <div style={editPaneStyle}>Hello</div>
          : null
        }
      </div>
    )
  }
}
// if logged in - show admin bar
if (window.localStorage.login) {
  console.log(window.localStorage);
  // showAdmin.init();
  ReactDOM.render(<App />, document.getElementById('adminNav'));
}
