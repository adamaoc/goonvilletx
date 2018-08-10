console.log('Goonville, TX');

// countdown timer
function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var daysSpan = clock.querySelector('.days');
  var hoursSpan = clock.querySelector('.hours');
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    var t = getTimeRemaining(endtime);

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
      clearInterval(timeinterval);
    }
  }

  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}

var gameDateElm = document.getElementsByClassName('game-countdown__counter');
var gameDate = '';
if (gameDateElm.length > 0) {
  var gameDate = gameDateElm[0].dataset.gamedate + ' 19:30:00';
  console.log(gameDate);
  var deadline = new Date(Date.parse(new Date(gameDate)) + 0 * 24 * 60 * 60 * 1000);
  initializeClock('clockdiv', deadline);
}


// navigation control

var navigation = {
  init: function() {
    this.mobileBtn = document.getElementsByClassName('site-header__mobile')[0];
    this.navMenu = document.getElementById('siteNav');
    this.isOpen = false;
    this.setupEvents();
  },
  setupEvents: function() {
    this.mobileBtn.addEventListener('click', this.toggleMenu.bind(this));
  },
  toggleMenu: function() {
    if (this.isOpen) {
      // close
      this.navMenu.classList.remove('open');
      this.isOpen = false;
      document.body.style.overflow = '';
    } else {
      // open
      this.navMenu.classList.add('open');
      this.isOpen = true;
      document.body.style.overflow = 'hidden';
    }
  }
}

navigation.init();

var listenModal = {
  init: function() {
    this.listenBtn = document.getElementById('listenBtn');
    this.modal = document.querySelector('.player-modal');
    this.closeModalBtn = document.getElementById('closeModal');
    if (this.listenBtn) {
      this.setListener();
    }
  },
  setListener: function() {
    this.listenBtn.addEventListener('click', this.openModal.bind(this));
    this.closeModalBtn.addEventListener('click', this.closeModal.bind(this));
  },
  openModal: function() {
    this.modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  },
  closeModal: function() {
    this.modal.style.display = 'none';
    document.body.style.overflow = '';
  }
}
listenModal.init();
