<template>
  <v-app id="inspire">
    <v-app-bar app color="indigo" dark>
      <v-toolbar-title>Event Calendar</v-toolbar-title>
    </v-app-bar>
    <v-main>
      <v-snackbar v-model="snackBar" top color="success" timeout="2000">Saved!</v-snackbar>
      <v-container fluid>
        <v-row>
          <v-col xl="4" lg="4" sm="12" cols="12">
            <Form @validate="readData"></Form>
          </v-col>
          <v-col xl="8" lg="8" sm="12" cols="12" class="text-center">
            <template v-for="(i,ind) in formData.range">
              <Month :key="ind" :eventData="formData" :monthYear="i"></Month>
            </template>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  props: {
    source: String,
  },
  data: () => ({
    drawer: null,
    formData: {},
    snackBar: false,
  }),
  mounted() {
    this.readData({
      fromDate: this.moment().format("YYYY-MM-DD"),
      toDate: this.moment().format("YYYY-MM-DD"),
      days: [],
    });
  },
  methods: {
    readData(data) {
      this.snackBar = data.saved || false;
      var dateEnd = this.moment(data.toDate, "YYYY-MM");
      var dateStart = this.moment(data.fromDate, "YYYY-MM");
      var dateStartCopy = dateStart.clone();
      var timeValues = [];

      while (
        dateEnd > dateStartCopy ||
        dateStartCopy.format("M") === dateEnd.format("M")
      ) {
        timeValues.push(dateStartCopy.format("YYYY-MM"));
        dateStartCopy.add(1, "month");
      }

      this.formData = {
        ...data,
        range: timeValues,
      };
    },
  },
};
</script>

