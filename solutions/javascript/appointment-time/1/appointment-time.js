// @ts-check

/**
 * Create an appointment
 *
 * @param {number} days
 * @param {number} [now] (ms since the epoch, or undefined)
 *
 * @returns {Date} the appointment
 */
export function createAppointment(days, now = undefined) {
  const addDays = days * 24 * 60 * 60 * 1000;
  return (now) ? 
    new Date(Number(now) + addDays) : new Date(Date.now() + addDays);
}

/**
 * Generate the appointment timestamp
 *
 * @param {Date} appointmentDate
 *
 * @returns {string} timestamp
 */
export function getAppointmentTimestamp(appointmentDate) {
  return appointmentDate.toISOString();
}

/**
 * Get details of an appointment
 *
 * @param {string} timestamp (ISO 8601)
 *
 * @returns {Record<'year' | 'month' | 'date' | 'hour' | 'minute', number>} the appointment details
 */
export function getAppointmentDetails(timestamp) {
  const datum = new Date(timestamp);
  console.log('datum')
  console.log(datum)
  return { 
    'year' : datum.getFullYear(), 
    'month' : datum.getMonth(), 
    'date' : datum.getDate(), 
    'hour' : datum.getHours(), 
    'minute' : datum.getMinutes()
  };
}

/**
 * Update an appointment with given options
 *
 * @param {string} timestamp (ISO 8601)
 * @param {Partial<Record<'year' | 'month' | 'date' | 'hour' | 'minute', number>>} options
 *
 * @returns {Record<'year' | 'month' | 'date' | 'hour' | 'minute', number>} the appointment details
 */
 
export function updateAppointment(timestamp, options) {

  const datum = new Date(timestamp);
  for(let option in options) {
    const value = options[option];
    switch(option) {
      case 'year' :
        datum.setFullYear(value);
        break;
      case 'month' :
        datum.setMonth(value);
        break;
      case 'date' :
        datum.setDate(value);
        break;
      case 'hour' :
        datum.setHours(value);
        break;
      case 'minute' :
        datum.setMinutes(value);
        break;
    }
  }
  return getAppointmentDetails(datum.toString());
  
}


/**
 * Get available time in seconds (rounded) between two appointments
 *
 * @param {string} timestampA (ISO 8601)
 * @param {string} timestampB (ISO 8601)
 *
 * @returns {number} amount of seconds (rounded)
 */
export function timeBetween(timestampA, timestampB) {
  const timeA = new Date(timestampA).getTime();
  const timeB = new Date(timestampB).getTime();
  return (timeA >= timeB) ?
    Math.ceil((timeA - timeB) / 1000) : Math.ceil((timeB - timeA) / 1000);
}

/**
 * Get available times between two appointment
 *
 * @param {string} appointmentTimestamp (ISO 8601)
 * @param {string} currentTimestamp (ISO 8601)
 */
export function isValid(appointmentTimestamp, currentTimestamp) {
  return new Date(appointmentTimestamp) > new Date(currentTimestamp);
}
