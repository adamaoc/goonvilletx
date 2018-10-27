import React, { Component } from 'react'
import { APIURL } from '../../constants/AppConstants';
import PostListTable from './PostListTable';

export const RadioContext = React.createContext();

class RadioProvider extends Component {
  constructor(props) {
    super(props);
    this.state = {
      radioPosts: null
    }
  }
  componentDidMount() {
    const fetchUrl = APIURL + '/radio-posts/';
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
        radioPosts: resp.posts
      });
    });
  }

  handleListDataUpdate(id, field, value) {
    debugger;
  }

  render() {
    return (
      <RadioContext.Provider value={{
          state: this.state,
          handleListDataUpdate: this.handleListDataUpdate
        }}>
        {this.props.children}
      </RadioContext.Provider>
    )
  }
}

class EditRadioPost extends Component {
  constructor(props) {
    super(props)
  }

  render() {
    return (
      <RadioProvider>
        <PostListTable />
      </RadioProvider>
    )
  }
}

export default EditRadioPost