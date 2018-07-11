import React from 'react';
import styled from 'styled-components';

const Table = styled.table`
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
`;

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
    const apiUrl = (window.location.host === 'goonvilletx.com') ? 'http://goonvilletx.com/api' : 'http://localhost:8888/api';
    const fetchUrl = apiUrl + '/schedule/';
    const games = fetch(
      fetchUrl
    ).then((resp) => {
      return resp.json();
    }).then((resp) => {
      this.setState({ games: resp.games });
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
            </tr>
          </thead>
          <tbody>
            {this.state.games.map((game) => {
              return (
                <tr key={game.id}>
                  <td className="score">{game.id}</td>
                  <td>{game.date}</td>
                  <td>{game.home_team}</td>
                  <td className="score">{game.home_score}</td>
                  <td>{game.visiting_team}</td>
                  <td className="score">{game.visiting_score}</td>
                  <td>{game.location}</td>
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
