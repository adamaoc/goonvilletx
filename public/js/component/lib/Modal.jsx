import React from 'react';
import styled from 'styled-components';
import { Button } from './Buttons';

export const ModalBG = styled.div`
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(0,0,0,0.3);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
`;

export const Modal = styled.div`
  background-color: white;
  border-radius: 5px;
  color: #444;
  text-align: center;
  padding: 2em 3em;
`;

export const BasicModal = (props) => {
  return (
    <ModalBG>
      <Modal>
        {props.children}
        <Button onClick={props.handleClose}>Cancel</Button> {" "}
        <Button onClick={props.handleConfirm} primary>Confirm</Button>
      </Modal>
    </ModalBG>
  )
}
