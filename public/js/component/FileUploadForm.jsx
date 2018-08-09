import React from 'react';
import { UploadImgBtn } from './lib/Buttons';

export const FileUploadForm = ({ uploadImg }) => {
  let fileInput = null;
  return (
    <div>
      <input
        type="file"
        onChange={uploadImg}
        style={{display: 'none'}}
        ref={fi => fileInput = fi}
      />
      <UploadImgBtn onClick={() => fileInput.click()}>Upload</UploadImgBtn>
    </div>
  )
}
