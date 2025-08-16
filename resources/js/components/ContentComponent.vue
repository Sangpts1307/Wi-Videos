<template>
    <div class="col-md-6" id="content">
        <div class="row">
            <div class="clear-fix"></div>
            <div class="col-md-12 poster-information">
                <p class="poster-name">{{ video?.author.name }}</p>
                <span v-if="!video?.my_video && !video?.follow" class="txt-follow">Theo dõi</span>
                <span v-if="!video?.my_video && video?.follow" class="txt-follow">Bỏ theo dõi</span>
                <i class="fa fa-heart-circle-plus text-danger" id="icon-like"></i>
                <a href="#" data-toggle="modal" data-target="#report-modal">
                    <img src="../../../public/assets/images/ic_report.png" width="18px" height="18px" alt="" id="icon-report">
                </a>
            </div>
            <div class="col-md-12" id="video-section">
                <div class="show-video" id="show-video">
                    <iframe :src="video?.video_url" allow="autoplay"></iframe>
                    <p id="video-caption">{{ video?.caption }}</p>
                </div>
                <div class="col-md-12" id="btn-control">
                    <button class="btn btn-danger" v-on:click="back()">
                        &#60;
                    </button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#upload-videos-modal"> <strong>+</strong> </button>
                    <button class="btn btn-danger" v-on:click="next()">
                        &#62; 
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import Vue from 'vue'
    //import axios from 'axios'
    // import component1 from 'component1'
    // import component2 from 'component2'

    export default {
        /***********************************************************************************************************
         ******************************* Pass data to child component **********************************************
         **********************************************************************************************************/
        props: ["txtMSG"],
        // components: {component1, component2},
        data() {
            /***********************************************************************************************************
             ******************************* Initialize global variables ***********************************************
             **********************************************************************************************************/
            return {
                video: null,
                videoId: 1
            }
        },
        /**
         * Define global service socket
         *
         * Listing event from socket.io server
         * "ServerSendCommentToClient" is the name of the channel that sends notifications to all clients installed in the server socket
         */
        sockets: {
            // Send data to server
            ClientSendCommentToServer: function (responseComment) {
                this.comment = responseComment;
            },
            // Listen event from server and render data
            ServerSendCommentToClient: function (responseComment) {
                // Push to the comment list
                if (responseComment.type === 'comment' && this.transaction.id == responseComment.transaction_id) {
                    this.pushCommentToList(responseComment);
                    this.$forceUpdate();
                }
            },
        },
        created() {
            /***********************************************************************************************************
             *********************** Initialize data when this component is used. **************************************
             **********************************************************************************************************/
            console.log('Init created component and call to function get data from api server.');
            // this.joinRoom();
            this.callAPI();
        },
        mounted() {
            /***********************************************************************************************************
             ******************** Once created, the interface is displayed and calls mounted. **************************
             **********************************************************************************************************/
        },
        watch: {
            /***********************************************************************************************************
             ********************************* Methods change value for a variable *************************************
             **********************************************************************************************************/
            msg() {
                console.log("When the value of the msg variable changes, this method will be executed.");
            }
        },
        computed: {
            appendMsg() {
                return msg + "Process the value and assign the value to the corresponding variable the var has changed.";
            }
        },
        methods: {
            /***********************************************************************************************************
             ******************************* Default functions that handle local data **********************************
             **********************************************************************************************************/

            /**
             * Example default function not using param
             */
            defaultFunction() {
                this.msg = "Replace message here!";
            },
            // Join a room
            joinRoom() {
                this.$socket.emit('ClientSendCommentToServer', {
                    // Pass param obj
                    transaction_id: 1
                });
            },
            /**
             * Example default function using param 
             *
             * @param int pageNum number of page
             * @return boolean
             */
            defaultFunctionUsingParam(pageNum) {
                console.log(pageNum);
                return false;
            },

            next() {
                this.videoId = this.videoId + 1;
                this.callAPI();
            },
            back() {
                this.videoId = this.videoId - 1;
                this.callAPI();
            },


            /***********************************************************************************************************
             ******* Async and await functions for manipulating server-side data through internal API protocols ********
             **********************************************************************************************************/

            /**
             * Call API sample
             */
            async callAPI() {
                try {
                    const callAPI = await axios.get('get-video?video_id=' + this.videoId, {
                        /************ Attach param for request here ***************/
                    });
                    console.log(callAPI.data.data);
                    this.video = callAPI.data.data;
                } catch (err) {
                    console.log(err);
                }
            },
        },
    }
</script>