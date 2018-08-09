import styled from 'styled-components';
const GoonBlue = '#02255a';

export const Table = styled.table`
  border-collapse: collapse;
  border: 1px solid #aaa;
  width: 100%;
  thead tr {
    border-bottom: 1px solid #888;
    font-weight: bold;
  }
  tbody tr:nth-child(odd) {
    background: #fff;
  }
  td {
    padding: 0.5rem;
    a {
      color: ${GoonBlue};
      text-decoration: none;
    }
  }
  .actions {
    width: 150px;
  }
  .score {
    text-align: center;
    width: 110px;
  }
  .center {
    text-align: center;
  }
  .editable {
    input[type='text'] {
      height: 1.875em;
      width: 100%;
      font-size: 1em;
      padding-left: 0.75em;
    }
  }

  .game-editor {
    padding: 1em;
  }
`;
