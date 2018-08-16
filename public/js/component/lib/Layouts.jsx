import styled, { css }  from 'styled-components';

export const PushRight = styled.div`
  display: flex;
  justify-content: flex-end;
`;


export const AdminSection = styled.div`
  background: #eaeaea;
  border: 1px solid #c1c1c1;
  padding: 1em;
  margin-bottom: 1em;
  section {
    display: flex;
    justify-content: stretch;
    align-items: stretch;
  }
  h5 {
    margin-left: 18px;
    margin-bottom: 5px;
  }
`;

export const FormGroup = styled.div`
  border: 1px dashed #888;
  padding: 1em;
  margin: 0 1em 1em;
  flex: 1;
  background: #fff;
  label {
    display: block;
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #a7a7a7;
    padding-left: 0.5rem;
    font-weight: bold;
    letter-spacing: 1px;
  }
  input {
    margin-bottom: 1em;
    width: 100%;
  }
  textarea {
    width: 100%;
    height: 300px;
    font-size: 16px;
  }
`;

export const FlexGroup = styled.div`
  display: flex;
  align-items: center;
  justify-content: space-between;
`;
