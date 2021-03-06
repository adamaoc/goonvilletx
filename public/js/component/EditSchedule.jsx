import React from 'react';
import styled from 'styled-components';
import { Table } from './lib/Tables';
import { Button, ClearButton, SVGButton } from './lib/Buttons';
import { Loading } from './lib/Loading';
import GamePostEditor from './GamePostEditor';
import { APIURL } from '../constants/AppConstants';

const LinkSVG = () => {
  return (
    <svg x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24">
      <g transform="translate(0, 0)">
        <path fill="none" stroke="#ffffff" strokeWidth="2" strokeLinecap="square" strokeMiterlimit="10" d="M15,7h3c2.8,0,5,2.2,5,5v0c0,2.8-2.2,5-5,5h-3" strokeLinejoin="miter"></path>
        <path fill="none" stroke="#ffffff" strokeWidth="2" strokeLinecap="square" strokeMiterlimit="10" d="M9,17H6c-2.8,0-5-2.2-5-5v0c0-2.8,2.2-5,5-5h3" strokeLinejoin="miter"></path>
        <line datacolor="color-2" fill="none" stroke="#ffffff" strokeWidth="2" strokeLinecap="square" strokeMiterlimit="10" x1="8" y1="12" x2="16" y2="12" strokeLinejoin="miter"></line>
      </g>
    </svg>
  )
}

class EditSchedule extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      selectedGame: null,
      loading: true,
      games: [],
      season: '',
      addingRow: false,
      newGame: {}
    }
  }
  componentDidMount() {
    const fetchUrl = APIURL + '/schedule/';
    const games = fetch(
      fetchUrl
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({
        games: resp.schedule.games,
        season: resp.schedule.season,
        loading: false
      });
    });
  }
  updateData(id, field, value) {
    const { games } = this.state;
    games.forEach((game) => {
      if (game.id === id) {
        game[field] = value;
      }
    });
    this.setState({ games });
  }
  updateRow(id) {
    const {games} = this.state;
    let game = games.filter((s) => s.id === id);
    const fetchUrl = APIURL + '/schedule/update/';
    this.setState({loading: true});
    const newSpon = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(game[0])
      }
    ).then((resp) => { return resp.json()}).then((resp) => {
      games.forEach((game) => {
        if (game.id === resp.game.id) {
          game = resp.game;
        }
      })
      setTimeout(() => {
        this.setState({
          loading: false,
          games
        });
      }, 300);
    });
  }

  updatedSelected(id) {
    if (this.state.selectedGame === id) {
      this.setState({ selectedGame: null });
    } else {
      this.setState({ selectedGame: id });
    }
  }

  updateNewGameData(field, value) {
    const { newGame } = this.state;
    newGame[field] = value;
    this.setState({ newGame });
  }

  postNewGame() {
    let { newGame, games } = this.state;
    let newGameId = '1001';
    
    if (games.length > 0) {
      console.log(games);
      newGameId = Number(games[(games.length - 1)].id) + 1;
    }
    newGame['id'] = newGameId;
    newGame['home_score'] = "0";
    newGame['visiting_score'] = "0";

    console.log(newGame);

    const fetchUrl = APIURL + '/schedule/addnew/';
    this.setState({loading: true});

    const postGame = fetch(
      fetchUrl,
      {
        method: 'post',
        headers: {
          Token: window.token
        },
        body: JSON.stringify(newGame)
      }
    ).then((resp) => { return resp.json()}).then((resp) => {
      games.push(resp.game);
      setTimeout(() => {
        this.setState({
          loading: false,
          games,
          addingRow: false,
          newGame: {}
        });
      }, 300);
    });
  }

  render() {
    const {
      games,
      loading,
      selectedGame,
      addingRow
    } = this.state;

    if (!games) {
      return <div>Loading</div>
    }
    return (
      <div className="schedule-table">
        <h2>{this.state.season} schedule</h2>
        <div style={{position: 'relative'}}>
          <Table>
            <thead>
              <tr>
                <td className="score">ID</td>
                <td>Date</td>
                <td>Home Team</td>
                <td className="score">Home Score</td>
                <td>Visiting Team</td>
                <td className="score">Visiting Score</td>
                <td>Location</td>
              <td className="center">
                {addingRow 
                  ? null
                  : <Button onClick={() => this.setState({addingRow: true})}>+ Add Row</Button>
                }
              </td>
              </tr>
            </thead>
            <tbody>
              {addingRow
                ? (
                  <tr>
                    <td className="center"> -- </td>
                    <td className="editable">
                      <input type="date" onChange={(e) => this.updateNewGameData('date', e.target.value)} />
                    </td>
                    <td className="editable">
                      <input type="text" placeholder="Home Team" onChange={(e) => this.updateNewGameData('home_team', e.target.value)} />
                    </td>
                    <td className="score">
                      --
                    </td>
                    <td className="editable">
                      <input type="text" placeholder="Visiting Team" onChange={(e) => this.updateNewGameData('visiting_team', e.target.value)} />
                    </td>
                    <td className="score">
                      --
                    </td>
                    <td className="editable">
                      <input type="text" placeholder="Game Location" onChange={(e) => this.updateNewGameData('location', e.target.value)} />
                    </td>
                    <td>
                      <Button onClick={() => this.postNewGame()}>Post</Button>
                    </td>
                  </tr>
                )
                : null
              }
              {games.map((game) => {
                return (
                  <React.Fragment key={game.id}>
                    <tr>
                      <td className="center">
                        <ClearButton onClick={(e) => {
                            e.preventDefault;
                            this.updatedSelected(game.id);
                          }}>{game.id}</ClearButton>
                      </td>
                      <td className="editable">
                        <input type="date" defaultValue={game.date} onChange={(e) => this.updateData(game.id, 'date', e.target.value)} />
                      </td>
                      <td className="editable">
                        <input type="text" defaultValue={game.home_team} onChange={(e) => this.updateData(game.id, 'home_team', e.target.value)} />
                      </td>
                      <td className="score editable">
                        <input type="text" defaultValue={game.home_score} onChange={(e) => this.updateData(game.id, 'home_score', e.target.value)} />
                      </td>
                      <td className="editable">
                        <input type="text" defaultValue={game.visiting_team} onChange={(e) => this.updateData(game.id, 'visiting_team', e.target.value)} />
                      </td>
                      <td className="score editable">
                        <input type="text" defaultValue={game.visiting_score} onChange={(e) => this.updateData(game.id, 'visiting_score', e.target.value)} />
                      </td>
                      <td className="editable">
                        <input type="text" defaultValue={game.location} onChange={(e) => this.updateData(game.id, 'location', e.target.value)} />
                      </td>
                      <td>
                        <Button onClick={() => this.updateRow(game.id)}>Update</Button>
                      </td>
                    </tr>
                    {selectedGame === game.id
                      ? (
                        <tr className="game-editor">
                          <td colSpan={8}>
                            <div className="game-editor">
                              <h3>Edit Game ({game.id})</h3>
                              <GamePostEditor
                                id={game.id}
                                close={() => this.updatedSelected(game.id)}
                              />
                            </div>
                          </td>
                        </tr>
                      )
                      : null
                    }
                </React.Fragment>
                )
              })}
            </tbody>
          </Table>
          {loading
            ? <Loading>Loading...</Loading>
            : null
          }
        </div>
      </div>
    );
  }
};

export default EditSchedule;
