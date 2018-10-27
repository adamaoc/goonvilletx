import React, { Component } from 'react';
import { Table } from '../lib/Tables';
import { ClearButton } from '../lib/Buttons';
import { RadioContext } from './EditRadioPosts';
import RadioPostEditor from './RadioPostEditor';


const PostListRows = ({ rows, updateRowSelected, rowSelected }) => {
  return (
    <React.Fragment>
      {rows.map((row) => (
        <React.Fragment key={row.id}>
          <tr>
            <td className="editable center">
              <ClearButton onClick={(e) => {
                  e.preventDefault;
                  updateRowSelected(row.id);
                }}>
                {row.id} (edit)
              </ClearButton>
            </td>
            <td>
              {row.post_title}
            </td>
            <td>
              {row.status}
            </td>
            <td>
              {row.author}
            </td>
            <td>
              {row.date_published}
            </td>
          </tr>
          {rowSelected === row.id
            ? <tr><td colSpan={5}><RadioPostEditor {...row} close={updateRowSelected.bind(null, 'close')} /></td></tr>
            : null
          }
        </React.Fragment>
      ))}
    </React.Fragment>
  )
}
class PostListTable extends Component {
  constructor(props) {
    super(props)
    this.state = {
      rowSelected: null
    }
  }
  updateRowSelected(id) {
    if (this.state.rowSelected === id || id === 'close') {
      this.setState({ rowSelected: null })
    } else {
      this.setState({ rowSelected: id });
    }
  }
  render() {
    return (
      <RadioContext.Consumer>
        {(context) => (
          <Table>
            <thead>
              <tr>
                <td className="center">ID</td>
                <td>post_title</td>
                <td>status</td>
                <td>author</td>
                <td>date_published</td>
              </tr>
            </thead>
            <tbody>
              {context.state.radioPosts
                ? <PostListRows 
                    rows={context.state.radioPosts} 
                    updateData={context.handleListDataUpdate} 
                    updateRowSelected={this.updateRowSelected.bind(this)} 
                    rowSelected={this.state.rowSelected} />
                : <tr><td colSpan={5}>Loading...</td></tr>
              }
            </tbody>
          </Table>
        )}
      </RadioContext.Consumer>
    )
  }
}
export default PostListTable