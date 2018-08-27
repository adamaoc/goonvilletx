import React from 'react';
import { FormGroup } from '../lib/Layouts';
import { FormGroupEdit } from './FormGroupEdit';

export const SocialInfo = ({ info, handleSocialChange }) => {
  const infoFields = ['twitter', 'facebook'];
  return (
    <FormGroup>
      {infoFields.map((field, i) => {
        return <FormGroupEdit key={i} field={field}
                              value={info[field]}
                              handleChange={handleSocialChange} />
      })}
    </FormGroup>
  )
}
