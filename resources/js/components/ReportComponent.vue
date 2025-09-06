<template>
    <!-- Modal report -->
    <div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="report-modal">Báo cáo vi phạm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="report-content">Nội dung báo cáo (<span class="text-danger">*</span>) </label>
                    <textarea name="report" v-model="reportContent" class="form-control" id="report-content"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-danger" v-on:click="sendReport()">Gửi báo cáo</button>
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
        
        // components: {component1, component2},
        props: ["videoId"],

        data() {
            /***********************************************************************************************************
             ******************************* Initialize global variables ***********************************************
             **********************************************************************************************************/
            return {
                video: null,
                reportContent: ''
            }
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

            async sendReport() {
                try {
                    const callReportAPI = await axios.post('send-report', {
                        /************ Attach param for request here ***************/
                        video_id: this.videoId,
                        report_content: this.reportContent
                    });
                    console.log(callReportAPI.data);
                } catch (err) {
                    console.log(err);
                }
            }
        },
    }
</script>