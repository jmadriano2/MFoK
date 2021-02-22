<template>
    <div class="collapse" id="step1">
        <div class="card card-body">
            <ol>
                <li>
                    Open Midas, go to Enquiries > Global Views > Fusion Midas Dashboard
                </li>
                <li>
                    The dashboard shows all the WIP transactions in a particular zone. To start CoB processing, the zone must have zero items on the column 'Unauthorized Items'.
                </li>
                <li>
                    Select the zone and a list of pending items would be shown.
                </li>
                <li>
                    Selecting any item with the word 'Unauth' would bring up the module where the transaction is listed on the WIP. Reject or authorize the transactions as needed. Some transactions may only be authorized using the command line. Query the file GPMTXTPD to find the appropriate menu screen to authorize the transactions.
                </li>
                <li>
                    Repeat steps 1 - 4 as necessary.
                </li>
            </ol>
        </div>
    </div>
</template>
