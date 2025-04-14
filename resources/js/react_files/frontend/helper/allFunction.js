
import dayjs from "dayjs";
import { Link } from '@inertiajs/react'

const allFunction = {   

  shortName : (text)=> {
    let letter = ''
    const myArray = text.split(" ");
    myArray.forEach(function (item, index) {
      letter += item[0].toUpperCase()      
    });
    return letter;
  },
  limit : ()=> {    
    return 10;
  },  
  generateRandomNumber : (length)=>{
    var randomValues = '';
    var stringValues = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';  
    var sizeOfCharacter = stringValues.length;  
    for (var i = 0; i < length; i++) {
      randomValues = randomValues+stringValues.charAt(Math.floor(Math.random() * sizeOfCharacter));
    }
    return randomValues;
  },
  dateTimeFormat: (myDateTime)=> {    
    return dayjs(myDateTime).format('MMM D, YYYY h:mm A');
  },
  dateFormat: (myDateTime)=> {    
    return dayjs(myDateTime).format('MMM D, YYYY');
  },
  currency: (amount, currency_code)=>{
    const codes = {
      'INR':'₹',
      'GBP':'£',
      'USD':'$',
      'AUD':'A$'
    }
    let Amt = amount.replace('.00', '');
    return codes[currency_code] + Amt; 
  },
  objToQuerystring : (obj)=> {
    const keyValuePairs = [];
    for (let i = 0; i < Object.keys(obj).length; i += 1) {
      keyValuePairs.push(`${encodeURIComponent(Object.keys(obj)[i])}=${encodeURIComponent(Object.values(obj)[i])}`);
    }
    return keyValuePairs.join('&');
  },
  get_localTime : (obj)=> {
    let localTime = new Date(new Date().toLocaleString("en-US", {timeZone: "CAT"}));
    return localTime
  },  
  hasPrototype: (obj) => {
    return Object.getPrototypeOf(obj) !== Object.prototype;
  },
  getStar: (num) => {
    let max = 5
    let number = Math.round(num)    
    let remaining_number = Number(max - number)

    let star = ''
    for(let i=1; i<=number; i++){
      star += '<i className="fas fa-star text-warning"></i>'
    }
    for(let j=1; j<=remaining_number; j++){
      star += '<i className="fas fa-star text-muted"></i>'
    }

    return star
  },
  getOrdinal: (n) => {
    let ord = 'th';
    if (n % 10 == 1 && n % 100 != 11){
      ord = 'st';
    }
    else if (n % 10 == 2 && n % 100 != 12){
      ord = 'nd';
    }
    else if (n % 10 == 3 && n % 100 != 13){
      ord = 'rd';
    }
    return n + ord;
  },

}
export default allFunction;