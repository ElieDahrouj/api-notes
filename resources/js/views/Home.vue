<template>
    <div>
        <div class="notes">
            <notes></notes>
            <div class="field">
                <p>Date: {{getterSingleNoteDate}} | Words: {{getterSingleNoteLength}}</p>
                <textarea v-model="newContent=getterSingleNote.content" @keyup="debounceInput(newContent)" rows="20" cols="10" placeholder="Votre note">{{getterSingleNote.content}}</textarea>
            </div>
            <footer @click="newNote">
                <p><font-awesome-icon :icon="['fas', 'plus']" /></p>
            </footer>
        </div>
    </div>
</template>
<script>
    import { mapGetters , mapActions} from 'vuex'
    import notes from  '../components/Notes'
    import { debounce } from "debounce";
    export default {
        name:'home',
        data(){
          return{
              newContent:null
          }
        },
        computed:{
            ...mapGetters(['getterSingleNote','getterSingleNoteLength','getterSingleNoteDate'])
        },
        methods:{
            ...mapActions(['addNote','newNote']),
            debounceInput: debounce(function (e) {
                this.addNote(e)
            }, 1000)
        },
        components:{
            notes
        },
    }
</script>
<style scoped lang="scss">
    .notes{
        display: flex;
        align-items: flex-start;
        .field{
            width: 70%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            p{
                text-align: center;
                font-family: Arial;
                color: #9c9c9c;
            }
            textarea{
                padding: 15px;
                width: 100%;
                height: 94vh;
                border: none;
                outline:none;
            }
        }
        footer{
            p {
                background-color:black;
                position: absolute;
                padding:15px;
                border-radius:100%;
                bottom: 0;
                right: 0;
                color:whitesmoke;
                margin-right: 20px;
                margin-bottom: 10px;
                cursor:pointer;
            }
        }
    }
</style>