<template>
    <loading-card :loading="loading" class="metric px-6 py-4 relative">
        <div class="flex mb-3">
            <h3 class="mr-2 text-base text-80 font-bold">{{ card.name }}</h3>
        </div>

        <table>
            <tr>
                <th class="text-right">SystemTime</th>
                <td class="pl-4">{{ moment(systemTime).format('LLL') }}</td>
            </tr>
            <tr v-if="upTime > 0">
                <th class="text-right">UpTime</th>
                <td class="pl-4">{{ this.humanTime(upTime) }}</td>
            </tr>
            <tr v-if="avg > 0">
                <th class="text-right">LoadAvg</th>
                <td class="pl-4">{{ avg }}</td>
            </tr>
            <tr>
                <th class="text-right">Memory</th>
                <td class="pl-4">used {{ mem.used }} of {{ mem.total }}</td>
            </tr>
            <tr>
                <th class="text-right">Disk</th>
                <td class="pl-4">used {{ disk.used }} of {{ disk.total }}</td>
            </tr>
        </table>
    </loading-card>
</template>

<script>

    let moment = require('moment');

export default {
    props: {
        card: {},
        loading: {default: true},
    },

    data() {
        return {
            avg: 0,
            mem: {
                free: 0,
                used: 0,
                total: 0,
            },
            disk: {
                free: 0,
                used: 0,
                total: 0,
            },
            systemTime: '',
            upTime: '',

        }
    },

    mounted() {
        this.refreshStatsPeriodically();
        moment.locale(window.navigator.userLanguage || window.navigator.language);
    },

    methods: {

        moment: function () {
            return moment();
        },

        refreshStatsPeriodically() {
            this.loading = true;
            Promise.all([
                this.loadStats(),
            ]).then(() => {
                this.loading = false;

                this.timeout = setTimeout(() => {
                    this.refreshStatsPeriodically(false);
                }, 5000);
            });
        },

        loadStats() {
            Nova.request().get('nova-vendor/SystemInformationCard/stats').then(
                (response) => {
                    this.avg = response.data.avg;
                    this.disk = response.data.disk;
                    this.mem = response.data.mem;
                    this.upTime = response.data.upTime;
                    this.systemTime = response.data.systemTime;
                });
        },

        /**
         *
         * @returns {string}
         */
        humanTime(time) {
            return moment.duration(time, "seconds").humanize().replace(/^(.)|\s+(.)/g, function ($1) {
                return $1.toUpperCase();
            });
        }
    }
}
</script>
