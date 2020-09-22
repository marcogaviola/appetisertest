<template>
  <v-form ref="form" v-model="valid" :lazy-validation="lazy">
    <v-container fluid>
      <v-row>
        <v-col lg="12" md="12" sm="12" cols="12">
          <v-text-field v-model="form.event" label="Event" :rules="requiredField"></v-text-field>
        </v-col>
        <v-col lg="6" md="6" sm="6" cols="12">
          <v-menu
            v-model="from"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="form.fromDate"
                :rules="requiredField"
                label="From"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker v-model="form.fromDate" @input="from = false"></v-date-picker>
          </v-menu>
        </v-col>
        <v-col lg="6" md="6" sm="6" cols="12">
          <v-menu
            v-model="to"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="form.toDate"
                :rules="requiredField"
                label="To"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker v-model="form.toDate" @input="to = false"></v-date-picker>
          </v-menu>
        </v-col>
        <v-spacer></v-spacer>
        <template v-for="(day,index) in moment.weekdaysShort()">
          <v-col class="px-0" :key="day.id">
            <v-checkbox
              dense
              v-model="form.days[index]"
              :label="day"
              :value="JSON.stringify(index)"
            ></v-checkbox>
          </v-col>
        </template>
      </v-row>
    </v-container>
    <v-btn :disabled="!valid" color="success" class="mr-4" @click="validate">Save Event</v-btn>
  </v-form>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    valid: true,
    lazy: false,
    from: "",
    to: "",
    form: {
      event: "",
      fromDate: "",
      toDate: "",
      days: [],
    },
    requiredField: [(v) => !!v || "Field is required"],
  }),
  mounted() {},
  methods: {
    validate() {
      if (this.form.days.length === 0) {
        alert("Please select any day");
        return false;
      }
      if (!this.moment(this.form.toDate).isAfter(this.form.fromDate)) {
        alert("Date Invalid");
        return false;
      }
      if (this.$refs.form.validate()) {
        axios
          .post("/api/event", {
            description: this.form.event,
            from_date: this.form.fromDate,
            to_date: this.form.toDate,
            days_covered: this.form.days.filter((obj) => obj),
          })
          .then((response) => {
            this.$emit("validate", {
              ...this.form,
              days: this.form.days.filter((obj) => obj),
              saved: true,
            });
            // this.$refs.form.reset();
          });
      }
    },
  },
};
</script>