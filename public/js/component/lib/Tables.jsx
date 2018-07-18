import styled from 'styled-components';

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
  }
  .score {
    text-align: center;
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
`;
