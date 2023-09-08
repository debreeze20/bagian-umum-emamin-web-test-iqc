import axios from 'axios';

export default () => {   
    const instance =  axios.create({
        baseURL: baseUrl,        
    });
    
    return instance;
}
