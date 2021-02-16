<template>
  <!-- Pre-CoB Rituals List -->
  <div class="row">
    <div class="col-sm-10 offset-sm-1">
      <div class="list-group">
        <a
            href="#step1"
            class="list-group-item list-group-item-action"
            data-toggle="collapse"
            :class="{active: isItem1Expanded}"
            v-on:click="toggleListItem(1)">
                1.0 - Check for Outstanding Transactions
        </a>
        <PreCobItem1></PreCobItem1>
        <a
            href="#step2"
            class="list-group-item list-group-item-action"
            data-toggle="collapse"
            :class="{active: isItem2Expanded}"
            v-on:click="toggleListItem(2)">
                2.0 - Check for objects in xxINVLIB that could affect CoB output
        </a>
        <PreCobItem2></PreCobItem2>
        <a
            href="#step3"
            class="list-group-item list-group-item-action"
            data-toggle="collapse"
            :class="{active: isItem3Expanded}"
            v-on:click="toggleListItem(3)">
                3.0 - Check for requested Halts for bug investigation
        </a>
        <PreCobItem3></PreCobItem3>
        <a
            href="#step4"
            class="list-group-item list-group-item-action"
            data-toggle="collapse"
            :class="{active: isItem4Expanded}"
            v-on:click="toggleListItem(4)">
                4.0 - Run VALD
        </a>
        <PreCobItem4></PreCobItem4>
        <a
            href="#step5"
            class="list-group-item list-group-item-action"
            data-toggle="collapse"
            :class="{active: isItem5Expanded}"
            v-on:click="toggleListItem(5)">
                5.0 - Check Queue Managers and Channels are Active
        </a>
        <PreCobItem5></PreCobItem5>
        <a
            href="#step6"
            class="list-group-item list-group-item-action"
            data-toggle="collapse"
            :class="{active: isItem6Expanded}"
            v-on:click="toggleListItem(6)">
                6.0 - Check System Status
        </a>
        <PreCobItem6></PreCobItem6>
        <a
            href="#step7"
            class="list-group-item list-group-item-action"
            data-toggle="collapse"
            :class="{active: isItem7Expanded}"
            v-on:click="toggleListItem(7)">
                7.0 - Sign-in to BFMI to check if WAS is up
        </a>
        <PreCobItem7></PreCobItem7>
        <a
            href="#step8"
            class="list-group-item list-group-item-action"
            data-toggle="collapse"
            :class="{active: isItem8Expanded}"
            v-on:click="toggleListItem(8)">
                8.0 - Clear Message Queues
        </a>
        <PreCobItem8></PreCobItem8>
      </div>
    </div>
  </div>
</template>

<script>
import PreCobItem1 from "./PreCobItem1";
import PreCobItem2 from "./PreCobItem2";
import PreCobItem3 from "./PreCobItem3";
import PreCobItem4 from "./PreCobItem4";
import PreCobItem5 from "./PreCobItem5";
import PreCobItem6 from "./PreCobItem6";
import PreCobItem7 from "./PreCobItem7";
import PreCobItem8 from "./PreCobItem8";

export default {
    components: {
        PreCobItem1,
        PreCobItem2,
        PreCobItem3,
        PreCobItem4,
        PreCobItem5,
        PreCobItem6,
        PreCobItem7,
        PreCobItem8
    },
    data() {
        return {
            isItem1Expanded: false,
            isItem2Expanded: false,
            isItem3Expanded: false,
            isItem4Expanded: false,
            isItem5Expanded: false,
            isItem6Expanded: false,
            isItem7Expanded: false,
            isItem8Expanded: false
        }
    },
    methods: {
        toggleListItem(listNumber) {
            if (listNumber == 1) {
                this.isItem1Expanded = !this.isItem1Expanded;
            } else if (listNumber == 2) {
                this.isItem2Expanded = !this.isItem2Expanded;
            } else if (listNumber == 3) {
                this.isItem3Expanded = !this.isItem3Expanded;
            } else if (listNumber == 4) {
                this.isItem4Expanded = !this.isItem4Expanded;
            } else if (listNumber == 5) {
                this.isItem5Expanded = !this.isItem5Expanded;
            } else if (listNumber == 6) {
                this.isItem6Expanded = !this.isItem6Expanded;
            } else if (listNumber == 7) {
                this.isItem7Expanded = !this.isItem7Expanded;
            } else if (listNumber == 8) {
                this.isItem8Expanded = !this.isItem8Expanded;
            }

        }
    }
}
</script>
