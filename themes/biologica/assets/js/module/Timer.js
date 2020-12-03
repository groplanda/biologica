const Timer = (id, deadline) => {

  const addZero = (num) => {
      if(num <= 9) {
          return '0' + num;
      } else {
          return num;
      }
  }

  const getTimeRemaining = (endtime) => {
      const total = Date.parse(endtime) - Date.parse(new Date()),
            seconds = Math.floor((total / 1000) % 60),
            minutes = Math.floor((total / (1000 * 60)) % 60),
            hours = Math.floor((total / (1000 * 3600)) % 24),
            days = Math.floor((total / (1000 * 3600 * 24)));
      return {
          total,
          seconds,
          minutes,
          hours,
          days
      }
  }

  const setClock = (selector, endtime) => {
      const timer = document.querySelector(selector),
          cSeconds = timer.querySelector('#second'),
          cMinutes = timer.querySelector('#minute'),
          cHours = timer.querySelector('#hour'),
          cDays = timer.querySelector('#day'),
          timerId = setInterval(updateClock, 1000);

          updateClock();

      function updateClock() {
          const {total, seconds, minutes, hours, days} = getTimeRemaining(endtime);

          cSeconds.textContent = addZero(seconds);
          cMinutes.textContent = addZero(minutes);
          cHours.textContent = addZero(hours);
          cDays.textContent = addZero(days);

          if(Number(total) <= 0) {
              cSeconds.textContent = "00";
              cMinutes.textContent = "00";
              cHours.textContent = "00";
              cDays.textContent = "00";
              clearInterval(timerId);
          }
      }
  }

  setClock(id, deadline)

}

export default Timer;