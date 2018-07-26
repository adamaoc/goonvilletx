import styled, { css }  from 'styled-components';

const GoonBlue = '#02255a';
const DarkenBlue = '#031735';

export const Button = styled.button`
  display: inline-block;
  border-radius: 3px;
  padding: 0.5rem 1rem;
  background: ${props => props.primary ? GoonBlue : '#eee'};
  color: ${props => props.primary ? 'white' : '#333' };
  border: 2px solid #cacaca;
  cursor: pointer;
  font-weight: bold;
  text-transform: uppercase;
  transition: all ease-in-out 200ms;

  &:hover {
    background: ${props => props.primary ? DarkenBlue : '#cacaca'};
    border: 2px solid #888;
  }
  &:disabled {
    background: #eee;
    color: #888;
    cursor: not-allowed;
  }
`;

export const UploadImgBtn = styled.button`
  background: white;
  border: 3px dashed #eee;
  text-align: center;
  line-height: 50px;
  width: 60px;
  height: 60px;
  cursor: pointer;
  color: #888;
  font-weight: bold;
`;

export const SVGButton = styled.button`
  background: transparent;
  border: none;
  color: #888;
  cursor: pointer;
  margin-left: 0.5rem;
  svg {
    fill: #888;
  }
  &:hover {
    svg {
      fill: #941212;
    }
  }
`;

export const ClearButton = styled.button`
  background: transparent;
  border: none;
  color: inherit;
  cursor: pointer;
  font-size: 1rem;
`;
