<template>
    <section>
        <transition name="fade">
            <div v-if="notif" class="notif">
                {{getterMsgDelete}}
            </div>
        </transition>
        <h1>Laravel Note X</h1>
        <ul class="ArrayNotes" >
            <li v-for="note in getterNotes">
                <button @click="deleteDefinitively(note.id)" :value="note.id"><font-awesome-icon :icon="['fas', 'times']" /></button>
                <button @click="getNote(note.id)" :value="note.id">{{note.content}}</button>
            </li>
        </ul>
    </section>
</template>
<script>
    import {mapActions, mapGetters} from 'vuex'
    export default {
        name:'Notes',
        data(){
            return{
                notif :false,
            }
        },
        computed:{
            ...mapGetters(['getterNotes','getterMsgDelete'])
        },
        methods:{
            ...mapActions(['allNotes','singleNote','deleteNote','updateNote']),
            getNote(itself){
                this.singleNote(itself)
            },
            deleteDefinitively(itself){
                this.getterNotes.forEach(note => {
                    if (note.id === itself) {
                        this.deleteNote(itself)
                        this.getterNotes.splice(this.getterNotes.indexOf(note), 1)
                        this.notif = true
                        setTimeout(() => {
                            this.notif = false
                        }, 3000)
                    }
                })
            },
        },
        beforeMount(){
            this.allNotes()
        }
    }
</script>
<style scoped lang="scss">
    /* width */
    ::-webkit-scrollbar {
        width: 8px;
        border-radius:3px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    section{
        width: 25%;
        background-color: #f8f8f8;
        height: 100vh;
        overflow-y: scroll;
        h1{
            font-family: Arial;
            text-align: center;
            font-weight: bold;
            margin:15px 0;
        }
        .ArrayNotes {
            padding:0;
            list-style: none;
            li {
                display: flex;
                justify-content: space-around;
                align-items: center;
                button:nth-child(1){
                    border:none;
                    width:0
                }
                button{
                    width: 250px;
                    text-align: left;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    padding: 10px;
                    background-color: transparent;
                    border: none;
                    border-bottom: 1px solid #f0f0f0;
                    outline: none;
                    cursor: pointer;
                }
            }
        }
    }
    .notif{
        position: absolute;
        right: 0;
        margin-top: 20px;
        margin-right: 30px;
        background-color: #d4edda;
        border : 1px solid #cae6d0;
        color: #457a52;
        padding:10px;
        border-radius:3px;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>