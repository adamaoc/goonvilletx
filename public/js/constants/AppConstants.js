let APIURL = 'http://goonvilletx.com/api';
if (window.location.host !== 'goonvilletx.com') {
  APIURL = 'http://localhost:8888/api';
}
export { APIURL };
