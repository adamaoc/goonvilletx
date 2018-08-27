import React from 'react';
import { Input } from '../lib/Forms';

export const FormGroupEdit = ({ field, value, handleChange }) => {
  return (
    <React.Fragment>
      <label htmlFor="page-title">{field}</label>
      <Input type="text"
        defaultValue={value}
        autoComplete="off"
        onChange={(e) => handleChange(field, e.target.value)}
      />
    </React.Fragment>
  )
}
