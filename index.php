<?php

/** 
 *Plugin Name: Conter Show
 * Plugin URI: 
 * Description: .
 * Version: 1.5
 * Author: cloud web labs
 * Author URI: http://www.cloudweblabs.com
 */
function cl_countdowncb($ats)
{
    ob_start();
    $rand = rand();

    $ats = shortcode_atts(array(
        'above_text' => 'ABOVETEXT WILL BE YEAR',
        'below_text' => 'BELOWTEXT WILL BE YEAR',
        'seconds' => 100
    ), $ats, 'countdown');

    ?>

    <div class="time-container">
        <?php echo $ats["above_text"] != "" ? "<p class='counter_above_text'>" . $ats["above_text"] . "</p>" : "";
            ?>

        <div class="timer timer<?php echo $rand; ?> alert alert-primary" data-seconds-left="<?php echo $ats["seconds"]; ?>"></div>

        <div class="time-control-container clr-fl">
            <a href="#" class="timer-btn--timerstart timer-btn">start</a>
            <a href="#" class="timer-btn--timerpause timer-btn">pause</a>
            <a href="#" class="timer-btn--timerresume timer-btn">start</a>
            <a href="#" class="timer-btn--timerreset timer-btn">reset</a>
        </div>
        <?php echo $ats["below_text"] != "" ? "<p class='counter_below_text'>" . $ats["below_text"] . "</p>" : "";
            ?>
    </div>
    <script>
        (function($) {
            const selecterValue = ".timer<?php echo $rand; ?>";
            const selecterValueParent = $(selecterValue).parent();
            const timerstartbtn = selecterValueParent.find(
                ".timer-btn--timerstart"
            );
            const timerpausetbtn = selecterValueParent.find(
                ".timer-btn--timerpause"
            );
            const timerresetbtn = selecterValueParent.find(
                ".timer-btn--timerreset"
            );
            const timerresumebtn = selecterValueParent.find(
                ".timer-btn--timerresume"
            );

            const toggleElement = uiElements => {
                uiElements.forEach(function(el) {
                    const type = el.t;
                    const element = el.el;
                    type === "show" ? element.show() : element.hide();
                });
            };

            const timer1 = $(selecterValue).startTimer({
                onComplete: function(element) {
                    toggleElement([{
                            el: timerstartbtn,
                            t: "show"
                        },
                        {
                            el: timerresetbtn,
                            t: "show"
                        },
                        {
                            el: timerresumebtn,
                            t: "hide"
                        },
                        {
                            el: timerpausetbtn,
                            t: "hide"
                        }
                    ]);
                },
                loop: false
            });

            $(timerstartbtn).on("click", function(e) {
                e.preventDefault();

                timer1.trigger("resetime");
                timer1.trigger("start");

                toggleElement([{
                        el: timerstartbtn,
                        t: "hide"
                    },
                    {
                        el: timerresetbtn,
                        t: "show"
                    },
                    {
                        el: timerresumebtn,
                        t: "hide"
                    },
                    {
                        el: timerpausetbtn,
                        t: "show"
                    }
                ]);
            });

            $(timerpausetbtn).on("click", function(e) {
                e.preventDefault();

                timer1.trigger("pause");

                toggleElement([{
                        el: timerstartbtn,
                        t: "hide"
                    },
                    {
                        el: timerresetbtn,
                        t: "show"
                    },
                    {
                        el: timerresumebtn,
                        t: "show"
                    },
                    {
                        el: timerpausetbtn,
                        t: "hide"
                    }
                ]);
            });

            $(timerresetbtn).on("click", function(e) {
                e.preventDefault();

                timer1.trigger("resetime");

                toggleElement([{
                        el: timerstartbtn,
                        t: "show"
                    },
                    {
                        el: timerresetbtn,
                        t: "show"
                    },
                    {
                        el: timerresumebtn,
                        t: "hide"
                    },
                    {
                        el: timerpausetbtn,
                        t: "hide"
                    }
                ]);
            });

            $(timerresumebtn).on("click", function(e) {
                e.preventDefault();

                timer1.trigger("resume");

                toggleElement([{
                        el: timerstartbtn,
                        t: "hide"
                    },
                    {
                        el: timerresetbtn,
                        t: "show"
                    },
                    {
                        el: timerresumebtn,
                        t: "hide"
                    },
                    {
                        el: timerpausetbtn,
                        t: "show"
                    }
                ]);
            });
        })(jQuery);
    </script>
<?php
    return ob_get_clean();
}
add_shortcode("countdown", "cl_countdowncb");
function cl_add_css()
{
    wp_enqueue_style("counter-css", plugin_dir_url(__FILE__) . "style.css");
    wp_enqueue_script("counter-js", plugin_dir_url(__FILE__) . "app.js", array("jquery"), true);
}
add_action("wp_enqueue_scripts", "cl_add_css");
