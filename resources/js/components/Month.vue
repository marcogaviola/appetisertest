<template>
  <v-card class="my-7">
    <v-card-title>{{monthName}} {{this.dateData.year}}</v-card-title>
    <v-card-text>
      <v-simple-table class="text--left">
        <template v-slot:default>
          <tbody>
            <template v-for="day in dateData.days">
              <tr :key="day" :class="showEvent(day) ? 'green lighten-4' : ''">
                <td class="text-start" width="200">{{day}} {{dayShort(day).format("ddd")}}</td>
                <td class="text-start">
                  <template v-if="showEvent(day)">{{eventData.event}}</template>
                </td>
              </tr>
            </template>
          </tbody>
        </template>
      </v-simple-table>
    </v-card-text>
  </v-card>
</template>
<script>
export default {
  props: ["eventData", "monthYear"],
  computed: {
    dateData() {
      return {
        days: parseInt(this.moment(this.monthYear, "YYYY-MM").daysInMonth()),
        year: this.moment(this.monthYear).format("YYYY"),
      };
    },
    monthName() {
      return this.moment(this.monthYear).format("MMMM");
    },
  },
  methods: {
    dayShort(day) {
      return this.moment(this.monthYear + "-" + day);
    },
    getDay(day) {
      return this.dayShort(day).format("d");
    },
    showEvent(day) {
      return (
        this.moment(this.monthYear + "-" + day).isBetween(
          this.eventData.fromDate,
          this.eventData.toDate,
          undefined,
          "[]"
        ) && this.eventData.days.includes(this.getDay(day))
      );
    },
  },
};
</script>