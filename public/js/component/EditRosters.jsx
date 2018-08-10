import React from 'react';
import {
  PushRight,
  AdminSection,
  FormGroup
} from './lib/Layouts';
import { Table } from './lib/Tables';
import { FileUploadForm } from './FileUploadForm';
import { Loading } from './lib/Loading';
import { Button } from './lib/Buttons';
import { BasicModal } from './lib/Modal';
import { ActionButtons } from './ActionButtons';
import { APIURL } from '../constants/AppConstants';

class EditRosters extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      confirmAction: false,
      confirmFunc: null,
      loading: true,
      tempImg: null,
      playerRoster: null,
      coachRoster: null,
      newPlayer: {
        image: '',
        number: '',
        name: '',
        grade: '',
        positions: '',
        awards: ''
      },
      newCoach: {
        image: '',
        name: '',
        title: '',
        bio: ''
      }
    };
  }
  componentDidMount() {
    const fetchUrl = APIURL + '/rosters/all/';
    const rosters = fetch(
      fetchUrl
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({
        playerRoster: resp.rosters.players,
        coachRoster: resp.rosters.coaches,
        loading: false
      });
    });
  }
  uploadImg(roster, e) {
    const img = e.target.files[0];
    if (img) {
      let formData = new FormData();
      formData.append('file', img);
      const fetchUrl = APIURL + '/rosters/upload/';
      const file = fetch(
        fetchUrl,
        {
          method: 'post',
          headers: {
            Token: window.token
          },
          body: formData
        }
      ).then((resp) => {
        return resp.json();
      }).then((resp) => {
        if (roster === 'coaches') {
          let updatedCoach = this.state.newCoach;
          updatedCoach.image = resp.image.file_name;
          this.setState({
            tempImg: resp.image.file_path,
            newCoach: updatedCoach
          });
        } else {
          let updatedPlayer = this.state.newPlayer;
          updatedPlayer.image = resp.image.file_name;
          this.setState({
            tempImg: resp.image.file_path,
            newPlayer: updatedPlayer
          });
        }
      });
    }
  }
  addPlayer() {
    let { newPlayer } = this.state;
    const fetchUrl = APIURL + '/rosters/add-player/';
    const sponsors = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(newPlayer)
      }
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({
        playerRoster: resp.players,
        newPlayer: {
          image: '',
          number: '',
          name: '',
          grade: '',
          positions: '',
          awards: ''
        },
        tempImg: null
      });
    });
  }
  updateNewPlayerData(field, value) {
    const { newPlayer } = this.state;
    newPlayer[field] = value;
    this.setState({ newPlayer });
  }
  updateData(id, field, value) {
    let stateRoster = this.state.playerRoster;
    stateRoster.forEach((person) => {
      if (person.id === id) {
        person[field] = value;
      }
    });
    this.setState({ playerRoster: stateRoster });
  }

  updatePlayerRow(id) {
    const { playerRoster } = this.state;
    let player = playerRoster.filter((s) => s.id === id);
    const fetchUrl = APIURL + '/rosters/player-update/';
    this.setState({loading: true});
    const fetchPlayer = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(player[0])
      }
    ).then((resp) => { return resp.json()}).then((resp) => {
      playerRoster.forEach((player) => {
        if (player.id === resp.player.id) {
          player = resp.player;
        }
      })
      setTimeout(() => {
        this.setState({
          loading: false,
          playerRoster
        });
      }, 300);
    });
  }

  confirmRemove(func) {
    this.setState({
      confirmAction: true,
      confirmFunc: func
    });
  }

  closeConfirmAction() {
    this.setState({
      confirmAction: false,
      confirmFunc: null
    });
  }

  removePlayerRow(id) {
    const { playerRoster } = this.state;
    let newPlayerRoster = playerRoster.filter((s) => s.id !== id);
    const fetchUrl = APIURL + '/rosters/delete-player?id=' + id;
    const newSpon = fetch(
      fetchUrl,
      {
        method: 'delete',
        headers: {
          Token: window.token
        }
      }
    ).then((resp) => { return resp.json()}).then((resp) => {
      if (resp.error) {
        // handle error //
      } else {
        this.setState({
          playerRoster: newPlayerRoster,
          confirmAction: false,
          confirmFunc: null
        });
      }
    })
  }

  updateNewCoachData(field, value) {
    const { newCoach } = this.state;
    newCoach[field] = value;
    this.setState({ newCoach });
  }
  addCoach() {
    let { newCoach } = this.state;
    const fetchUrl = APIURL + '/rosters/add-coach/';
    const sponsors = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(newCoach)
      }
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({
        coachRoster: resp.coaches,
        newCoach: {
          image: '',
          name: '',
          title: '',
          bio: ''
        },
        tempImg: null
      });
    });
  }
  updateCoachData(id, field, value) {
    let stateRoster = this.state.coachRoster;

    stateRoster.forEach((person) => {
      if (person.id === id) {
        person[field] = value;
      }
    });
    this.setState({ coachRoster: stateRoster });
  }

  removeCoachRow(id) {
    const {coachRoster} = this.state;
    let newCoachRoster = coachRoster.filter((s) => s.id !== id);
    const fetchUrl = APIURL + '/rosters/delete-coach?id=' + id;
    const newSpon = fetch(
      fetchUrl,
      {
        method: 'delete',
        headers: {
          Token: window.token
        }
      }
    ).then((resp) => { return resp.json()}).then((resp) => {
      if (resp.error) {
        // handle error //
      } else {
        this.setState({
          coachRoster: newCoachRoster,
          confirmAction: false,
          confirmFunc: null
        });
      }
    })
  }
  render() {
    const { newPlayer, newCoach, tempImg, playerRoster, coachRoster, loading, confirmAction } = this.state;
    return (
      <div>
        <h2>Rosters</h2>
        <AdminSection>
          <h3>Team Roster</h3>
          <Table>
            <thead>
              <tr>
                <td>Photo</td>
                <td>Number</td>
                <td>Full Name</td>
                <td>Grade</td>
                <td>Positions</td>
                <td>Awards</td>
                <td className="center">--</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  {tempImg
                    ? <img src={`/${tempImg}`} width="50px" />
                    : <FileUploadForm uploadImg={this.uploadImg.bind(this, 'player')} />
                  }
                </td>
                <td className="editable">
                  <input type="text"
                         placeholder="Number"
                         value={newPlayer.number}
                         onChange={(e) => {this.updateNewPlayerData('number', e.target.value)}}
                  />
                </td>
                <td className="editable">
                  <input type="text"
                         placeholder="Full Name"
                         value={newPlayer.name}
                         onChange={(e) => {this.updateNewPlayerData('name', e.target.value)}}
                  />
                </td>
                <td className="editable">
                  <input type="text"
                         placeholder="Player Grade"
                         value={newPlayer.grade}
                         onChange={(e) => {this.updateNewPlayerData('grade', e.target.value)}}
                  />
                </td>

                <td className="editable">
                  <input type="text"
                         placeholder="Player Positions"
                         value={newPlayer.positions}
                         onChange={(e) => {this.updateNewPlayerData('positions', e.target.value)}}
                  />
                </td>

                <td className="editable">
                  <input type="text"
                         placeholder="Player Awards"
                         value={newPlayer.awards}
                         onChange={(e) => {this.updateNewPlayerData('awards', e.target.value)}}
                  />
                </td>
                <td className="center">
                  <Button onClick={() => this.addPlayer()}>+ Add</Button>
                </td>
              </tr>
                {playerRoster && playerRoster.length > 0
                  ? (
                    <React.Fragment>
                      {playerRoster.map((player) => {
                        return (
                          <tr key={player.id}>
                            <td><img src={`/data/rosters/imgs/${player.photo}`} width="50px" /></td>
                            <td className="editable score">
                              <input type="text" defaultValue={player.number} onChange={(e) => this.updateData(player.id, 'number', e.target.value)} />
                            </td>
                            <td className="editable">
                              <input type="text" defaultValue={player.name} onChange={(e) => this.updateData(player.id, 'name', e.target.value)} />
                            </td>
                            <td className="editable">
                              <input type="text" defaultValue={player.grade} onChange={(e) => this.updateData(player.id, 'grade', e.target.value)} />
                            </td>
                            <td className="editable">
                              <input type="text" defaultValue={player.positions} onChange={(e) => this.updateData(player.id, 'positions', e.target.value)} />
                            </td>
                            <td className="editable">
                              <input type="text" defaultValue={player.awards} onChange={(e) => this.updateData(player.id, 'awards', e.target.value)} />
                            </td>
                            <td className="actions">
                              <ActionButtons update={() => this.updatePlayerRow(player.id)} remove={() => this.confirmRemove(this.removePlayerRow.bind(this, player.id))} />
                            </td>
                          </tr>
                        )
                      })}
                    </React.Fragment>
                  )
                  : null
                }
            </tbody>
          </Table>
        </AdminSection>
        <AdminSection>
          <h3>Coaches Roster</h3>
          <Table>
            <thead>
              <tr>
                <td>Photo</td>
                <td>Full Name</td>
                <td>Title</td>
                <td>Bio</td>
                <td className="center">--</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  {tempImg
                    ? <img src={`/${tempImg}`} width="50px" />
                    : <FileUploadForm uploadImg={this.uploadImg.bind(this, 'coaches')} />
                  }
                </td>
                <td className="editable">
                  <input type="text"
                         placeholder="Full Name"
                         value={newCoach.name}
                         onChange={(e) => {this.updateNewCoachData('name', e.target.value)}}
                  />
                </td>
                <td className="editable">
                  <input type="text"
                         placeholder="Title"
                         value={newCoach.title}
                         onChange={(e) => {this.updateNewCoachData('title', e.target.value)}}
                  />
                </td>
                <td className="editable">
                  <input type="text"
                         placeholder="Coaches Bio (Short)"
                         value={newCoach.bio}
                         onChange={(e) => {this.updateNewCoachData('bio', e.target.value)}}
                  />
                </td>
                <td className="center">
                  <Button onClick={() => this.addCoach()}>+ Add</Button>
                </td>
              </tr>
                {coachRoster && coachRoster.length > 0
                  ? (
                    <React.Fragment>
                      {coachRoster.map((coach) => {
                        return (
                          <tr key={coach.id}>
                            <td><img src={`/data/rosters/imgs/${coach.photo}`} width="50px" /></td>
                            <td className="editable">
                              <input type="text" defaultValue={coach.name} onChange={(e) => this.updateCoachData(coach.id, 'name', e.target.value)} />
                            </td>
                            <td className="editable">
                              <input type="text" defaultValue={coach.title} onChange={(e) => this.updateCoachData(coach.id, 'title', e.target.value)} />
                            </td>
                            <td className="editable">
                              <input type="text" defaultValue={coach.bio} onChange={(e) => this.updateCoachData(coach.id, 'bio', e.target.value)} />
                            </td>
                            <td className="actions">
                              <ActionButtons update={() => this.updateCoachRow(coach.id)} remove={() => this.confirmRemove(this.removeCoachRow.bind(this, coach.id))} />
                            </td>
                          </tr>
                        )
                      })}
                    </React.Fragment>
                  )
                  : null
                }
            </tbody>
          </Table>
        </AdminSection>
        {loading
          ? <Loading>Loading...</Loading>
          : null
        }
        {confirmAction
          ? (
            <BasicModal handleConfirm={this.state.confirmFunc} handleClose={this.closeConfirmAction.bind(this)}>
              <p>Are you sure you want to remove this?</p>
            </BasicModal>
          )
          : null
        }
      </div>
    )
  }
}

export default EditRosters;
