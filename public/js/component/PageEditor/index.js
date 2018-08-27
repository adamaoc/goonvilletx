import React, { Component } from 'react';
import { PageContext } from '../EditPage';
import { Input } from '../lib/Forms';
import { Button } from '../lib/Buttons';
import {
  PushRight,
  AdminSection,
  FormGroup
} from '../lib/Layouts';

class PageEditor extends Component {
  render() {
    return (
      <PageContext.Consumer>
        {(context) => (
          <React.Fragment>
            <h2>Editing {context.state.pagePath} Page!</h2>
            <AdminSection>
              <h5>Edit Header Info.</h5>
              <section>
                <FormGroup>
                  <label htmlFor="page-title">Page Title: </label>
                  <Input type="text" defaultValue={context.state.pageData.page_title} autoComplete="off" onChange={(e) => { context.updateData('page_title', e.currentTarget.value)}} />
                </FormGroup>
                {context.state.pageData.action_btn_link !== 'null'
                  ? (
                    <FormGroup>
                      <label>Action Button Text</label>
                      <Input type="text" defaultValue={context.state.pageData.action_btn_text} onChange={(e) => { context.updateData('action_btn_text', e.currentTarget.value)}} />
                      <br />
                      <label>Action Button Link</label>
                      <Input type="text" defaultValue={context.state.pageData.action_btn_link} onChange={(e) => { context.updateData('action_btn_link', e.currentTarget.value)}} />
                    </FormGroup>
                  )
                  : null
                }
              </section>
            </AdminSection>
            <AdminSection>
              <h5>Page SEO</h5>
              <section>
                <FormGroup>
                  <label>SEO Title</label>
                <Input type="text" defaultValue={context.state.pageData.seo_title} autoComplete="off" onChange={(e) => { context.updateData('seo_title', e.currentTarget.value)}} />
                </FormGroup>
                <FormGroup>
                  <label>SEO Description</label>
                <Input type="text" defaultValue={context.state.pageData.seo_desc} autoComplete="off" onChange={(e) => { context.updateData('seo_desc', e.currentTarget.value)}} />
                </FormGroup>
              </section>
            </AdminSection>
            <PushRight>
              <Button primary onClick={() => {
                  context.updatePage();
                }}>Update {context.state.pagePath} Page</Button>
            </PushRight>
          </React.Fragment>
        )}
      </PageContext.Consumer>
    )
  }
}

export default PageEditor;
