import profileStore from "@/store/profile.js";

import {
    createStore
} from 'vuex'

const store = createStore({
    modules: {
        profile: profileStore,       
    }
})

export default store;
