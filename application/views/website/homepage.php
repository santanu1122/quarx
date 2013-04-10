<?php

/* Filename:    homepage.php
 * Location:    /application/views/
 * Author:      Matt Lantz
 */

?>

<div class="grid"><!-- content -->

    <div class="grid100 box gFFF">
        <h1><?php echo t('welcome'); ?></h1>
        <p>The grid is made of two main parts the grid and the raw grid. The grid is a column set that can be set to maintain a clean set of margins between them. The raw grid is the same columns without any margins.</p>
        <h5>Grid Columns</h5>
        <table class="tableAlternateRows paddedRows">
            <tr>
                <td><b>Size of Column</b></td>
                <td><b>Grid (With Margins)</b></td>
                <td><b>Raw Grid</b></td>
            </tr>
            <tr>
                <td>25% Column width</td>
                <td>grid25</td>
                <td>raw25</td>
            </tr>
            <tr>
                <td>33% Column width</td>
                <td>grid33</td>
                <td>raw33</td>
            </tr>
            <tr>
                <td>50% Column width</td>
                <td>grid50</td>
                <td>raw50</td>
            </tr>
            <tr>
                <td>66% Column width</td>
                <td>grid66</td>
                <td>raw66</td>
            </tr>
            <tr>
                <td>75% Column width</td>
                <td>grid75</td>
                <td>raw75</td>
            </tr>
            <tr>
                <td>100% Column width</td>
                <td>grid100</td>
                <td>raw100</td>
            </tr>
        </table>
    </div>

    <div class="grid50left box gEEE">
        <h1>Heading h1</h1>
        <h2>Heading h2</h2>
        <h3>Heading h3</h3>
        
    </div>
    <div class="grid50right box gDDD">
        <h4>Heading h4</h4>
        <h5>Heading h5</h5>
        <p>Paragraph</p>
        <a>Anchor</a>
    </div>

    <div class="grid25left box gCCC">
        <p>Unordered List</p>
        <ul>
            <li>List Item 1</li>
            <li>List Item 2</li>
            <li>List Item 3</li>
        </ul>
        <br />
        <p>Ordered List</p>
        <ol>
            <li>List Item 1</li>
            <li>List Item 2</li>
            <li>List Item 3</li>
        </ol>
    </div>
    <div class="grid25 box gBBB">
        <div class="padded10">
            <table>
                <tr>
                    <td colspan="3">A Simple Table</td>
                </tr>
                <tr>
                    <td><b>Book</b></td>
                    <td><b>Price</b></td>
                    <td><b>Stock</b></td>
                </tr>
                <tr>
                    <td>The Art of War</td>
                    <td>$8.99</td>
                    <td>56</td>
                </tr>
                <tr>
                    <td>The Prince</td>
                    <td>$4.99</td>
                    <td>77</td>
                </tr>
                <tr>
                    <td>The Hobbit</td>
                    <td>$7.99</td>
                    <td>2</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="grid25 box gAAA">
        <div class="padded10">
            <button class="standardButton">Button</button><br />
            <button class="go standardButton">Go</button><br />
            <button class="caution standardButton">Caution</button><br />
            <button class="stop standardButton">Stop</button>
        </div>
    </div>
    <div title="grid25right" class="grid25right box g999">
        <div class="padded10">
            <h3>Buttons</h3>
            <p>.standardButton</p>
            <ul>
                <li>width @ 120px</li>
                <li>Font-size @ 1em</li>
            </ul>
            <p>.go</p>
            <p>.caution</p>
            <p>.stop</p>
        </div>
    </div>

    <div class="grid25left box g888">
    </div>
    <div class="grid75right box g777">
    </div>

    <div class="grid33left box g666">
    </div>
    <div class="grid33 box g555">
    </div>
    <div class="grid33right box g444">
    </div>

    <div class="grid33left gridbottom box g333">
    </div>
    <div class="grid66right gridbottom box g222">
    </div>

    <div class="raw33 box g333">
    </div>
    <div class="raw66 box g222">
    </div>

</div><!--/content -->

<?php //End of file ?>