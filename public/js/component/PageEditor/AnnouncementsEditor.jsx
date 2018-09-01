import React from 'react';
import { Button } from '../lib/Buttons';
import {
    PushRight,
    AdminSection,
    FormGroup
  } from '../lib/Layouts';
  import { Table } from '../lib/Tables';

class AnnouncementsEditor extends React.Component {
    constructor(props) {
        super(props);
    }
    render() {
        return (
            <React.Fragment>
                <h2>Announcements</h2>
                <AdminSection>
                    <Table>
                        <thead>
                            <tr>
                                <td className="score">ID</td>
                                <td>Start Date</td>
                                <td>End Date</td>
                                <td>Type</td>
                                <td>Slug</td>
                                <td>Attachment</td>
                                <td className="center">--</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td className="score">1001</td>
                                <td>2018-10-01</td>
                                <td>2018-10-14</td>
                                <td>Flyer</td>
                                <td>new-anouncment</td>
                                <td>file</td>
                                <td className="center">--</td>
                            </tr>
                        </tbody>
                    </Table>
                </AdminSection>
                <PushRight>
                    <Button primary>Update Announcements</Button>
                </PushRight>
            </React.Fragment>
        )
    }
}

export default AnnouncementsEditor;
