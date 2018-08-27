import React, { Component } from 'react';
import { PageContext } from '../EditPage';
import { Button } from '../lib/Buttons';
import {
  FormGroup,
  FlexGroup
} from '../lib/Layouts';

class SchoolLogos extends Component {
  render() {
    let fileInput = null;
    return (
      <PageContext.Consumer>
        {(context) => (
          <FormGroup>
            <div style={{display: 'none'}}>
              <input
                type="file"
                onChange={context.replaceLogoImg}
                style={{display: 'none'}}
                ref={fi => fileInput = fi} />
            </div>
            <div>
              <label>Header Logo</label>
              <FlexGroup>
                <img src={context.state.schoolInfo.header_logo} height="50px" />
                <Button onClick={() => {
                  context.replaceImg('header_logo');
                  fileInput.click();
                }}>Replace</Button>
              </FlexGroup>
            </div>
            <div>
              <label>Footer Logo</label>
              <FlexGroup>
                <img src={context.state.schoolInfo.footer_logo} height="50px" />
                <Button onClick={() => {
                  context.replaceImg('footer_logo')
                  fileInput.click();
                }}>Replace</Button>
              </FlexGroup>
            </div>
          </FormGroup>
        )}
      </PageContext.Consumer>
    )
  }
}
export default SchoolLogos;
