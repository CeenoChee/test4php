import * as postcodes from './assets/postcodes.json';

class Postcode{
    get(){
        return postcodes;
    }
    getCityByCode(code){
        return this.get()[code];
    }
    getCodeByCity(city){
        const postcodes = this.get();
        return Object.keys(postcodes).find(key => postcodes[key] === city);
    }
}

export default Postcode;