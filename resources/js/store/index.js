import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import moment from 'moment'
Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        ArrayNotes:[],
        oneNote: {},
        wordNumber:null,
        updateTime:moment().format('lll'),
        msgDelete: null,
        msgSucess:null,
    },
    getters: {
        getterNotes(state) {
            return state.ArrayNotes
        },
        getterSingleNote(state){
            return state.oneNote
        },
        getterSingleNoteLength(state){
          return state.wordNumber
        },
        getterSingleNoteDate(state){
            return state.updateTime
        },
        getterMsgDelete(state){
            return state.msgDelete
        }
    },
    mutations: {
        displayNotes(state,data){
            state.ArrayNotes = data
        },
        displayOneNote(state,data){
            state.oneNote = data
            state.wordNumber = data.content.trim().split(' ').length
            state.updateTime = moment(data.updated_at, 'YYYY-MM-DD h:mm:ss a').format('lll')
        },
        displayOneNoteLength(state,data){
            state.wordNumber = data.trim().split(' ').length
        },
        displayUpdateDate(state,data){
            state.updateTime = moment(data.updated_at, 'YYYY-MM-DD h:mm:ss a').format('lll')
        },
        deleteSuccessfully(state){
            state.msgDelete = "Note supprimée avec succès !"
        },
        createNote(state){
            state.msgSucess = "Création avec succès !"
        },
        emptyAllField(state,data){
            state.oneNote.content = data
            state.oneNote.id = data
            state.wordNumber = data
            state.updateTime = moment().format('lll')
        }
    },
    actions: {
        newNote({commit}){
            commit('emptyAllField',null)
        },
        allNotes({commit}){
            axios.get('http://127.0.0.1:8000/api/notes')
                .then(response =>{
                    commit('displayNotes',response.data.notes)
                })
        },
        singleNote({commit},id){
                axios.get('http://127.0.0.1:8000/api/notes/' + id)
                    .then(response => {
                        commit('displayOneNote', response.data.notes)
                    })
        },
        deleteNote({commit},id){
            axios.delete('http://127.0.0.1:8000/api/notes/'+id)
                .then(response => {
                    commit('deleteSuccessfully')
                })
        },
        addNote({commit,state,dispatch},data) {
            if (!state.oneNote.id) {
                axios.post('http://127.0.0.1:8000/api/notes', {content: data})
                    .then(response => {
                        commit('createNote')
                        commit('displayOneNote',response.data.note)
                        dispatch('allNotes')
                    })
            }
            else{
                axios.put('http://127.0.0.1:8000/api/notes/'+state.oneNote.id, {content: data})
                    .then(response => {
                        commit('displayOneNoteLength', response.data.notes.content)
                        commit('displayUpdateDate',response.data.notes)
                        dispatch('allNotes')
                    })
            }
        },
    },
})