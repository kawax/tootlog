<template>
    <tt-card>
        <vue-chart
            :packages="packages"
            chart-type="Calendar"
            :columns="columns"
            :rows="rows"
            :options="options"
            v-if="rows.length > 0"
        ></vue-chart>
    </tt-card>
</template>

<script>
import { parseISO } from "date-fns";

export default {
    data() {
        return {
            packages: ["calendar"],
            columns: [
                {
                    type: "date",
                    id: "Date"
                },
                {
                    type: "number",
                    id: "Toots"
                }
            ],
            rows: [],
            options: {
                title: "",
                calendar: {
                    monthLabel: {
                        fontName: "Nunito",
                        //                            fontSize: 12,
                        color: "#636b6f"
                        //                            bold: true,
                        //                            italic: true
                    },
                    monthOutlineColor: {
                        stroke: "#3097D1",
                        strokeOpacity: 0.8,
                        strokeWidth: 1
                    },
                    unusedMonthOutlineColor: {
                        stroke: "#636b6f",
                        strokeOpacity: 0.2,
                        strokeWidth: 1
                    },
                    dayOfWeekLabel: {
                        color: "#636b6f",
                        fontName: "Nunito",
                        fontSize: 12
                        //                            'italic': true,
                    },
                    focusedCellColor: {
                        stroke: "#3097D1",
                        strokeOpacity: 1,
                        strokeWidth: 2
                    },
                    yearLabel: {
                        fontName: "Nunito",
                        fontSize: 32,
                        //                            color: '#636b6f',
                        bold: true,
                        italic: true
                    }
                },
                noDataPattern: {
                    color: "#eee",
                    backgroundColor: "#fff"
                },
                colorAxis: {
                    minValue: 0,
                    colors: ["#fff", "#3097D1"]
                }
            }
        };
    },
    props: ["user", "acct"],
    mounted() {
        this.get();
    },
    methods: {
        get() {
            let url = "";

            if (!_.isEmpty(this.acct)) {
                url = "/" + this.acct;
            }

            axios
                .get("/api/calendar/" + this.user + url)
                .then(res => {
                    //                console.log(res.data)
                    this.rows = _.map(res.data, (value, key) => {
                        return Array(parseISO(key), value);
                    });
                    //                console.log(this.rows)
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    created() {
        this.$on("redrawChart", () => {
            console.log("redrawChart");
            for (idx in this.$children) {
                this.$children[idx].$emit("redrawChart");
            }
        });
    }
};
</script>
