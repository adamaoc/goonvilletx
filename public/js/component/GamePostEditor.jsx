import React from 'react';
import {
  PushRight,
  AdminSection,
  FormGroup
} from './lib/Layouts';
import { Button } from './lib/Buttons';
import { Loading } from './lib/Loading';
import { Input } from './lib/Forms';
import { APIURL } from '../constants/AppConstants';
import RichTextEditor, {createValueFromString} from 'react-rte';


class GamePostEditor extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      loading: true,
      title: '',
      author: '',
      status: '',
      content: RichTextEditor.createEmptyValue()
    }
    this.onEditorChange = this.onEditorChange.bind(this);
  }
  componentDidMount() {
    const fetchUrl = APIURL + '/schedule/game_post?id=' + this.props.id;
    const games = fetch(
      fetchUrl
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      let gamePost = resp.game;
      if (!gamePost) {
        this.setState({
          title: '',
          author: '',
          status: 'draft',
          content: RichTextEditor.createEmptyValue(),
          loading: false
        });
      } else {
        this.setState({
          title: gamePost.title,
          author: gamePost.author,
          status: gamePost.status,
          content: createValueFromString(gamePost.content, 'html'),
          loading: false
        });
      }
    });
  }

  updateData(item, value) {
    this.setState({ [item]: value });
  }

  updatePost() {
    let data = this.state;
    const fetchUrl = APIURL + '/schedule/game_post?id=' + this.props.id;
    data.content = data.content.toString('html');
    const gameD = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(data)
      }
    ).then((resp) => {
      return resp.json()
    }).then((resp) => {
      setTimeout(() => {
        this.props.close();
      }, 300);
    });
  }

  onEditorChange(editorState) {
    this.setState({ content: editorState });
  }

  render() {
    if (!this.state.loading) {
      const { title, author, content, status } = this.state;
      return (
        <div>
          <AdminSection>
            <FormGroup>
              <label>Post Title:</label>
              <Input type="text" placeholder="Enter Post Title Here" defaultValue={title} onChange={(e) => this.updateData('title', e.target.value)} />
            </FormGroup>
            <section>
              <FormGroup>
                <label>Post Author:</label>
                <Input type="text" placeholder="Enter Author's Name" defaultValue={author} onChange={(e) => this.updateData('author', e.target.value)} />
              </FormGroup>
              <FormGroup>
                <label>Post Status:</label>
                <select value={status} onChange={(e) => this.updateData('status', e.target.value)}>
                  <option value="draft">Draft</option>
                  <option value="published">Published</option>
                </select>
              </FormGroup>
            </section>
          </AdminSection>
          <AdminSection>
            <FormGroup>
              <label>Post Conent</label><br />
              <RichTextEditor
                placeholder="Enter post content here..."
                value={this.state.content}
                onChange={this.onEditorChange}
              />
            </FormGroup>
          </AdminSection>
          <PushRight>
            <Button onClick={() => this.props.close()}>Close</Button>
            <Button primary onClick={() => this.updatePost()}>Update Post</Button>
          </PushRight>
        </div>
      )
    }
    return <Loading>Loading...</Loading>
  }
}

export default GamePostEditor;
