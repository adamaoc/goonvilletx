import React from 'react';
import styled from 'styled-components';
import { Table } from './lib/Tables';
import { Button } from './lib/Buttons';

let APIURL = 'http://goonvilletx.com/api';
if (window.location.host !== 'goonvilletx.com') {
  APIURL = 'http://localhost:8888/api';
}

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
      games: []
    }
  }
  componentDidMount() {
    const fetchUrl = APIURL + '/schedule/';
    const games = fetch(
      fetchUrl
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({ games: resp.games });
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
    console.log(games);
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
  render() {
    if (!this.state.games) {
      return <div>Loading</div>
    }
    return (
      <div className="schedule-table">
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
              <td className="center">---</td>
            </tr>
          </thead>
          <tbody>
            {this.state.games.map((game) => {
              return (
                <tr key={game.id}>
                  <td className="score">{game.id}</td>
                  <td className="editable">
                    <input type="text" defaultValue={game.date} onChange={(e) => this.updateData(game.id, 'date', e.target.value)} />
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
              )
            })}
          </tbody>
        </Table>
      </div>
    );
  }
};

export default EditSchedule;
