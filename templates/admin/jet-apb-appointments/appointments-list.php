<div class="jet-apb-listing">
  <jet-apb-pagination></jet-apb-pagination>
  <cx-vui-list-table :is-empty="! itemsList.length">
    <cx-vui-list-table-heading :slots="columnsIDs" slot="heading">
      <span :key="column" :slot="column" :class="classColumn( column )" v-for="column in columnsIDs" @click="sortColumn( column )">{{ getItemLabel( column ) }}<svg v-if="! notSortable.includes( column )" class="jet-apb-active-column-icon" width="10" height="5" viewBox="0 0 10 5" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0.833374 0.333328L5.00004 4.5L9.16671 0.333328H0.833374Z" fill="#7B7E81" />
        </svg>
      </span>
    </cx-vui-list-table-heading>

    <template slot="items">
      <template v-for="( item, index ) in itemsList">
        <div v-if="item.isGroupChief && groupView" :class="classGroupChief( item.group_ID )" @click="showGroup( item.group_ID )">
          <div v-for="column in columnsIDs" :class="[ 'list-table-item__cell', 'cell--' + column ]">
            <a v-if="column === 'order_id' && getItemValue( item, column )" :href="getOrderLink( item[ column ] )" target="_blank">#{{ getItemValue( item, column ) }}</a>
            <span v-else-if="column === 'status'"></span>
            <span v-else-if="column === 'actions'" class="jet-apb-actions">
              <cx-vui-button button-style="link-error" size="link" @click="callPopup( 'delete-group', item )">
                <span slot="label"><?php esc_html_e('Delete group', 'jet-appointments-booking'); ?></span>
              </cx-vui-button>
            </span>
            <div v-else-if="column === 'ID'" class="group-toggl">
              <span class="group-toggl-arrow">
                <svg width="16" height="8" viewBox="0 0 16 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.799805 0.399902L7.9998 7.5999L15.1998 0.399902L0.799805 0.399902Z" fill="#7B7E81" />
                </svg>
              </span>
            </div>
            <div v-else-if="column === 'service'" class="group-title">
              <?php esc_html_e('Group', 'jet-appointments-booking'); ?> #{{item.group_ID}} - Contains {{ groupItemsCount[ item.group_ID ] }} <?php esc_html_e('appointments', 'jet-appointments-booking'); ?>
            </div>
            <template v-else-if="groupChiefColumnsIDs.includes(column)">{{ getItemValue( item, column ) }}</template>
            <template v-else></template>
          </div>
        </div>
        <div :class="classItem( item.group_ID )">
          <div v-for="column in columnsIDs" :class="[ 'list-table-item__cell', 'cell--' + column ]">
            <a v-if="column === 'order_id' && getItemValue( item, column )" :href="getOrderLink( item[ column ] )" target="_blank">#{{ getItemValue( item, column ) }}</a>
            <span v-else-if="column === 'status'" :class="{
		                        'notice': true,
		                        'notice-alt': true,
		                        'notice-success': isFinished( item.status ),
		                        'notice-warning': isInProgress( item.status ),
		                        'notice-error': isInvalid( item.status ),
		                    }">
              {{ getItemValue( item, column ) }}
            </span>
            <span v-else-if="column === 'actions'" class="jet-apb-actions">
              <cx-vui-button button-style="link-accent" size="link" @click="callPopup( 'update', item )">
                <span slot="label"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.5 12.375V15.5H3.625L12.8417 6.28333L9.71667 3.15833L0.5 12.375ZM2.93333 13.8333H2.16667V13.0667L9.71667 5.51667L10.4833 6.28333L2.93333 13.8333ZM15.2583 2.69167L13.3083 0.741667C13.1417 0.575 12.9333 0.5 12.7167 0.5C12.5 0.5 12.2917 0.583333 12.1333 0.741667L10.6083 2.26667L13.7333 5.39167L15.2583 3.86667C15.5833 3.54167 15.5833 3.01667 15.2583 2.69167Z" fill="#007CBA" />
                  </svg></span>
              </cx-vui-button>
              <cx-vui-button button-style="link-accent" size="link" @click="callPopup( 'info', item )">
                <span slot="label">
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.16667 4.83333H9.83333V6.5H8.16667V4.83333ZM8.16667 8.16666H9.83333V13.1667H8.16667V8.16666ZM9 0.666664C4.4 0.666664 0.666668 4.4 0.666668 9C0.666668 13.6 4.4 17.3333 9 17.3333C13.6 17.3333 17.3333 13.6 17.3333 9C17.3333 4.4 13.6 0.666664 9 0.666664ZM9 15.6667C5.325 15.6667 2.33333 12.675 2.33333 9C2.33333 5.325 5.325 2.33333 9 2.33333C12.675 2.33333 15.6667 5.325 15.6667 9C15.6667 12.675 12.675 15.6667 9 15.6667Z" fill="#007CBA" />
                  </svg>
                </span>
              </cx-vui-button>
              <!--  Phone No Call -->
              <a href="tel:7973151386">
                <cx-vui-button button-style="link-accent" size="link">
                  <span slot="label">

                    <span slot="label">
                      <svg width="20" height="20" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/1999/xlink">


                        <path class="st1" d="M1,6.89C1,5.43,1.55,4,2.54,2.91C3.65,1.7,5.23,1,6.87,1h7.89c2.99,0,5.5,2.23,5.83,5.19
		c0.2,1.74,0.56,3.47,1.07,5.15c0.64,2.09,0.08,4.35-1.45,5.88l-3.2,3.2c3.35,6.12,8.45,11.22,14.57,14.57l3.2-3.2
		c1.53-1.53,3.79-2.09,5.88-1.45c1.67,0.51,3.4,0.87,5.15,1.07c2.96,0.33,5.19,2.84,5.19,5.83v7.89c0,1.65-0.7,3.23-1.91,4.34
		c-1.22,1.11-2.87,1.67-4.51,1.51c-5.66-0.52-11.12-2.02-16.24-4.46c-4.97-2.37-9.48-5.55-13.39-9.46
		c-3.91-3.91-7.09-8.41-9.46-13.39C3.05,18.55,1.55,13.09,1.02,7.43C1.01,7.25,1,7.07,1,6.89L1,6.89z M18.01,13.08
		c0-0.2-0.03-0.4-0.09-0.6c-0.58-1.9-0.99-3.87-1.21-5.85c-0.11-0.98-0.95-1.73-1.95-1.73H6.87c-0.56,0-1.07,0.23-1.45,0.64
		C5.04,5.96,4.86,6.5,4.91,7.07C6.87,28.3,23.7,45.13,44.93,47.09c0.57,0.05,1.11-0.13,1.52-0.51c0.41-0.38,0.64-0.89,0.64-1.45
		v-7.89c0-1-0.74-1.84-1.73-1.95c-1.98-0.22-3.95-0.63-5.85-1.21c-0.71-0.22-1.47-0.03-1.98,0.48l-5.2,5.2l-1.26-0.63
		c-7.84-3.9-14.31-10.37-18.21-18.21l-0.63-1.26l5.2-5.2C17.82,14.09,18.01,13.59,18.01,13.08L18.01,13.08z M18.01,13.08" fill="#007CBA" />
                      </svg>
                    </span>
                </cx-vui-button>
              </a>
              <!--  WhatsApp button -->
              <a href=" https://wa.me/917973151386" target="_blank">
                <cx-vui-button button-style="link-accent" size="link">
                  <span slot="label">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2325 4589 c-241 -25 -467 -92 -690 -204 -313 -157 -550 -366 -746
                     -659 -425 -631 -445 -1459 -54 -2137 l44 -76 -170 -458 c-128 -347 -168 -466
                     -164 -487 8 -35 59 -78 92 -78 14 0 222 83 462 185 l436 185 155 -78 c454
                     -230 961 -287 1447 -163 691 177 1240 733 1409 1426 72 299 72 662 0 960 -150
                     612 -565 1120 -1141 1396 -330 158 -721 226 -1080 188z m385 -200 c826 -84
                     1496 -697 1662 -1520 20 -99 23 -143 23 -344 0 -181 -4 -249 -18 -320 -90
                     -449 -315 -819 -660 -1086 -585 -453 -1401 -492 -2051 -100 -51 31 -96 51
                     -113 51 -17 0 -187 -67 -379 -148 -192 -82 -350 -148 -352 -147 -1 1 58 167
                     133 368 74 201 135 377 135 389 0 13 -21 57 -47 98 -384 615 -382 1389 4 1975
                     363 551 1002 852 1663 784z" />
                      <path d="M1855 3773 c-116 -47 -264 -174 -340 -293 -84 -129 -108 -247 -86
                     -412 58 -435 346 -901 766 -1241 327 -265 691 -417 999 -420 84 0 113 4 173
                     25 170 60 352 232 420 398 39 94 26 197 -32 254 -17 17 -80 61 -140 97 -61 36
                     -159 96 -219 132 -170 104 -242 117 -335 60 -41 -26 -74 -61 -183 -193 l-37
                     -45 -38 14 c-93 33 -279 175 -404 309 -126 135 -239 301 -239 352 0 11 31 44
                     73 79 97 79 173 162 187 207 25 75 -6 154 -158 399 -150 241 -154 247 -201
                     272 -53 28 -145 31 -206 6z m153 -248 c19 -33 67 -112 107 -175 40 -63 82
                     -134 93 -157 l22 -42 -67 -58 c-201 -174 -224 -208 -203 -306 27 -131 139
                     -304 309 -480 221 -228 438 -367 578 -368 72 -1 109 24 208 143 118 141 106
                     134 179 95 33 -19 124 -73 201 -120 77 -48 148 -92 159 -98 27 -16 15 -59 -39
                     -134 -85 -120 -215 -209 -320 -221 -69 -8 -232 19 -345 56 -597 198 -1156 818
                     -1256 1390 -31 180 -5 275 110 398 73 78 170 144 205 140 19 -2 34 -18 59 -63z" fill="#007CBA" />
                    </svg>
                  </span>
                </cx-vui-button>
              </a>
              <cx-vui-button button-style="link-error" size="link" @click="callPopup( 'delete', item )">
                <span slot="label"><svg width="12" height="16" viewBox="0 0 12 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.999998 13.8333C0.999998 14.75 1.75 15.5 2.66666 15.5H9.33333C10.25 15.5 11 14.75 11 13.8333V3.83333H0.999998V13.8333ZM2.66666 5.5H9.33333V13.8333H2.66666V5.5ZM8.91667 1.33333L8.08333 0.5H3.91666L3.08333 1.33333H0.166664V3H11.8333V1.33333H8.91667Z" fill="#D6336C" />
                  </svg></span>
              </cx-vui-button>
            </span>
            <template v-else>{{ getItemValue( item, column ) }}</template>
          </div>
        </div>
      </template>
    </template>
  </cx-vui-list-table>
  <jet-apb-pagination></jet-apb-pagination>
</div>