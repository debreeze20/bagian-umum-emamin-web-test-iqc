const profile = {
    namespaced: true,
    state: {
        isLoggedIn: false,
        id: '',
        name: '',
        roleId: '',
        roleName: ''
    },
    mutations: {
        SET_PROFILE_DATA(state, payload) {
            state.isLoggedIn = payload ? true : false;
            if (payload) {
                state.id = payload.id;
                state.roleId = payload.role ? payload.role.id : '';
                state.roleName = payload.role ? payload.role.name : '';
                state.name = payload.name ? payload.name : ''
            } else {
                state.id = '';
                state.roleId = '';
                state.roleName = '';
                state.name = '';
            }
        }
    }
}

export default profile;