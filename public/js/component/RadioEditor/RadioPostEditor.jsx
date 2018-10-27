import React, { Component } from 'react';
import RichTextEditor, {createValueFromString} from 'react-rte';
import {
  PushRight,
  AdminSection,
  FormGroup
} from '../lib/Layouts';
import { Button } from '../lib/Buttons';
import { Loading } from '../lib/Loading';
import { Input } from '../lib/Forms';
import { APIURL } from '../../constants/AppConstants';

class RadioPostEditor extends Component {
  constructor(props) {
    super(props)
    this.state = {
      post: RichTextEditor.createEmptyValue(),
      loading: true
    }
  }
  componentDidMount() {
    console.log('post props ', this.props)
    const fetchUrl = `${APIURL}/radio-posts/post?id=${this.props.id}`;
    const post = fetch(
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
        post: createValueFromString(resp.post, 'html'),
        loading: false
      });
    });
  }
  onEditorChange(editorState) {
    this.setState({ post: editorState });
  }
  updatePost() {
    let post = this.state;
    debugger;
    const fetchUrl = `${APIURL}/radio-posts/update?id=${this.props.id}`;
    post = post.toString('html');
    const fetchPost = fetch(
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
  render() {
    if (!this.state.loading) {
      console.log(this.props);
      const { post_title, author, status, date_published, id, slug, embeded } = this.props;
      return (
        <div style={{padding: '1em'}}>
          <h3>Edit</h3>
          <div>
            <AdminSection>
              <FormGroup>
                <label>Post Title:</label>
                <Input type="text" placeholder="Enter Post Title Here" defaultValue={post_title} onChange={(e) => this.updateData('title', e.target.value)} />
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
              <section>
                <FormGroup>
                  <label>Published Date</label>
                  <input type="date" defaultValue={date_published} onChange={(e) => updateData(id, 'date_published', e.target.value)} />
                </FormGroup>
                <FormGroup>
                  <label>Post Slug</label>
                  {slug}
                </FormGroup>
              </section>
            </AdminSection>
            <AdminSection>
              <FormGroup>
                <label>Embeded Content</label>
                <Input type="text" defaultValue={embeded} onChange={(e) => updateData(id, 'embeded', e.target.value)} />
              </FormGroup>
            </AdminSection>
            <AdminSection>
              <FormGroup>
                <label>Post Conent</label><br />
                <div style={{overflow: 'hidden', maxWidth: 'calc(100vw - 200px)', margin: '0 auto'}}>
                  <RichTextEditor
                    placeholder="Enter post content here..."
                    value={this.state.post}
                    onChange={this.onEditorChange.bind(this)}
                  />
                </div>
              </FormGroup>
            </AdminSection>
            <PushRight>
              <Button onClick={this.props.close}>Close</Button>
              <Button primary onClick={() => this.updatePost()}>Update Post</Button>
            </PushRight>
          </div>
        </div>
      )
    }
    return <Loading>Loading...</Loading>
  }
}

export default RadioPostEditor