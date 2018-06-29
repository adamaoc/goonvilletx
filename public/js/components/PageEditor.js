var pageEditor = {
  init: function(page) {
    this.blocks = [];
    this.page = page;
    this.getSEOElements();
    this.getEditableElements();
    this.render();
  },
  createPane: function() {
    var pane = document.createElement('div');
    pane.classList.add('edit-page-pane');
    document.body.appendChild(pane);
    return pane;
  },
  getSEOElements: function() {
    this.seoTitle = document.getElementById('seo_title').value;
    this.seoDesc = document.getElementById('seo_desc').value;
  },
  getEditableElements: function() {
    var editableBlocks = document.querySelectorAll('[data-editable]');
    editableBlocks.forEach((ele, i) => {
      const { name, label, type } = ele.dataset;
      var blockData = {
        name: name,
        label: label,
        type: type,
        value: ele.innerText
      };
      this.blocks[i] = blockData;
    });
  },
  buildItems: function() {
    var itemsArr = this.blocks.map((block) => {
      return `<p>
                <label for="${block.name}">${block.label}</label>
                <input id="${block.name}" type="${block.type}" value="${block.value}" />
              </p>`;
    });
    itemsArr.push(`<p><label for="edit_seo_title">SEO Title</label><input id="edit_seo_title" type="text" value="${this.seoTitle.toLocaleString()}" /></p>`);
    itemsArr.push(`<p><label for="edit_seo_desc">SEO Description</label><input id="edit_seo_desc" type="text" value="${this.seoDesc.toLocaleString()}" /></p>`);
    return itemsArr.join('');
  },
  render: function() {
    this.pane = this.createPane();
    var items = this.buildItems();
    this.pane.innerHTML = `<div>
                        <h3>Eidt ${this.page} Page</h3>
                        ${items}
                        <button onclick="pageEditor.save()">Save</button>
                      </div>`;
  },
  close: function() {
    this.pane.remove();
    showAdmin.removePane();
  },
  save: function() {
    this.blocks.forEach((block) => {
      block.value = document.getElementById(block.name).value;
      document.querySelectorAll('[data-name="'+ block.name +'"]')[0].innerText = block.value;
    });
    this.close();
  }
};
