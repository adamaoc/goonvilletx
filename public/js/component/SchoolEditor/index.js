import React, { Component } from 'react';
import {
  PushRight,
  AdminSection,
  FormGroup,
  FlexGroup
} from '../lib/Layouts';
import { Button } from '../lib/Buttons';
import { PageContext } from '../EditPage';
import { FormGroupEdit } from './FormGroupEdit';
import { SocialInfo } from './SocialInfo';
import SchoolLogos from './SchoolLogos';

const SchoolAddress = ({ address, handleAddressChange }) => {
  const addressFields = ['street', 'city', 'state', 'zip'];
  return (
    <FormGroup>
      {addressFields.map((field, i) => {
        return <FormGroupEdit key={i} field={field}
                              value={address[field]}
                              handleChange={handleAddressChange} />
      })}
    </FormGroup>
  )
}
const SchoolInfo = ({ info, handleInfoChange }) => {
  const infoFields = ['school_name', 'phone', 'email', 'mascot'];
  return (
    <FormGroup>
      {infoFields.map((field, i) => {
        return <FormGroupEdit key={i} field={field}
                              value={info[field]}
                              handleChange={handleInfoChange} />
      })}
    </FormGroup>
  )
}

class SchoolEditor extends Component {
  render() {
    return (
      <PageContext.Consumer>
        {(context) => (
          <React.Fragment>
            <h2>Edit School Details</h2>
            <AdminSection>
              <section>
                <SchoolInfo info={context.state.schoolInfo} handleInfoChange={context.updateSchoolInfo} />
                <SchoolAddress address={context.state.schoolInfo} handleAddressChange={context.updateSchoolAddress} />
              </section>
              <section>
                <SocialInfo info={context.state.schoolInfo} handleSocialChange={context.updateSchoolInfo} />
                <SchoolLogos />
              </section>
            </AdminSection>
            <PushRight>
              <Button primary onClick={() => {
                  context.postSchoolDetails();
                }}>Update School Details</Button>
            </PushRight>
          </React.Fragment>
        )}
      </PageContext.Consumer>
    )
  }
}

export default SchoolEditor;
