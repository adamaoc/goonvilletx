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
      title: '',
      author: '',
      status: '',
      slug: '',
      pubDate: '',
      embeded: '',
      heroImg: '',
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
      console.log('responce: ', resp);
      const { post_title, author, status, slug, date_published, hero_img, embeded } = resp.post.data;
      this.setState({
        title: post_title,
        author: author,
        status: status,
        slug: slug,
        pubDate: date_published,
        embeded: embeded,
        heroImg: hero_img,
        post: createValueFromString(resp.post.blog, 'html'),
        loading: false
      });
    });
  }
  onEditorChange(editorState) {
    this.setState({ post: editorState });
  }
  updatePost() {
    const { post, title, author, status, slug, pubDate, embeded, heroImg } = this.state;
    const data = {
      id: this.props.id,
      post_title: title,
      author: author,
      status: status,
      slug: slug,
      date_published: pubDate,
      embeded: embeded,
      hero_img: heroImg,
      blog: post.toString('html')
    };
    const fetchUrl = `${APIURL}/radio-posts/update?id=${this.props.id}`;
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
      // should update page and list page and maybe not close...
      setTimeout(() => {
          this.props.close();
        }, 300);
    });
  }
  render() {
    if (!this.state.loading) {
      const { title, author, status, pubDate, slug, embeded, heroImg } = this.state;
      return (
        <div style={{padding: '1em'}}>
          <h3>Edit</h3>
          <div>
            <AdminSection>
              <FormGroup>
                <label>Post Title:</label>
                <Input type="text" placeholder="Enter Post Title Here" defaultValue={title} onChange={(e) => this.setState({title: e.target.value})} />
              </FormGroup>
              <section>
                <FormGroup>
                  <label>Post Author:</label>
                  <Input type="text" placeholder="Enter Author's Name" defaultValue={author} onChange={(e) => this.setState({author: e.target.value})} />
                </FormGroup>
                <FormGroup>
                  <label>Post Status:</label>
                  <select value={status} onChange={(e) => this.setState({status: e.target.value})}>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                  </select>
                </FormGroup>
              </section>
              <section>
                <FormGroup>
                  <label>Published Date</label>
                  <input type="date" defaultValue={pubDate} onChange={(e) => this.setState({pubDate: e.target.value})} />
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
                <Input type="text" defaultValue={embeded} onChange={(e) => this.setState({embeded: e.target.value})} />
              </FormGroup>
            </AdminSection>
            <AdminSection>
              <FormGroup>
                <label>Hero Image</label>
                <p><em>Image Name:</em> {heroImg}</p>
                <div style={{border: '1px solid #888', padding: '1em', textAlign: 'center', marginBottom: '1em'}}>
                  <img src={`data/radio-posts/${slug}/${heroImg}`} />
                </div>
                <PushRight>
                  <Button>Upload Image</Button>
                </PushRight>
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