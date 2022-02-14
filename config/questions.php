<?php

return [
    'overall_description' => '
        Enter a Confidence Score for each element of the Business Model using the following Scale.<br/><br/>
        Confidence Score Scale:<br/>
        0: Not addressed yet; not within scope of this evaluation<br/>
        1: The team has provided little evidence, there is low confidence in the evidence<br/>
        2: The team has provided some evidence, there is medium to low confidence in the evidence<br/>
        3. The team has provided partial evidence not adequate to make a decision; neutral/moderate confidence<br/>
        4: The team has provided partial evidence adequate to make a premature decision, there is medium to medium high confidence in the evidence<br/>
        5: The team has provided adequate evidence to make a decision, there is high confidence in the evidence<br/><br/>

        Confidence Score: Individual score demonstrating the quality and quantity of evidence for each component of the business model across the four confidence criteria.<br/><br/>

        Evidence Evaluation Criteria: <br/>
        (Low Confidence//High Confidence)<br/>
        - Customer Say//Customer Do<br/>
        - Lab Context//Real World<br/>
        - Opinion//Facts & Data<br/>
        - Low Fidelity//High Fidelity<br/>
    ',
    'business-model' => [
        [
            'question' => 'Opportunity Segments',
            'abbrev' => 'Opp Segments',
            'description' => 'The team is targeting a clearly defined, underserved segment for value-creation.',
            'color' => 'yellow-500',
            'section' => 'Desirability_(Market)',
            'order' => 8,
            'classes' => 'row-span-3'
        ], [
            'question' => 'Customer Need',
            'abbrev' => 'Cust Need',
            'description' => 'The team is addressing a clearly defined, unmet user need.',
            'color' => 'yellow-500',
            'section' => 'Desirability_(Market)',
            'order' => 1,
            'classes' => 'row-span-3'
        ], [
            'question' => 'Value Proposition',
            'abbrev' => 'Value Prop',
            'description' => 'There is a clear definition of value being delivered to the opportunity segment (value = solution satisfies unmet need).',
            'color' => 'yellow-500',
            'section' => 'Desirability_(Market)',
            'order' => 4,
            'classes' => 'row-span-3'
        ], [
            'question' => 'Solution',
            'abbrev' => 'Solution',
            'description' => 'The technology or solution is technically feasible & scalable.',
            'color' => 'purple-500',
            'section' => 'Feasability_(Technical)',
            'order' => 2,
            'classes' => 'col-span-2 row-span-2'
        ], [
            'question' => 'Channels',
            'abbrev' => 'Channels',
            'description' => 'There is clear evidence of the channel(s) through which value can be delivered to the customer.',
            'color' => 'purple-500',
            'section' => 'Feasability_(Technical)',
            'order' => 6,
            'classes' => 'col-span-2'
        ], [
            'question' => 'Competitive Advantage',
            'abbrev' => 'Comp Adv',
            'description' => 'There is a clear definition of how the solution is different or more valuable compared to competing solutions and offerings.',
            'color' => 'purple-500',
            'section' => 'Feasability_(Technical)',
            'order' => 5,
            'classes' => 'col-span-2 row-span-2'
        ], [
            'question' => 'Key Metrics',
            'abbrev' => 'Key Metrics',
            'description' => 'There is clear evidence of the metrics used for how success is measured.',
            'color' => 'green-500',
            'section' => 'Viability_(Regulatory)',
            'order' => 3,
            'classes' => 'col-span-2 '
        ], [
            'question' => 'Revenue',
            'abbrev' => 'Revenue',
            'description' => 'There is revenue OR a clear definition of how the solution can be monetized.',
            'color' => 'green-500',
            'section' => 'Viability_(Regulatory)',
            'order' => 9,
            'classes' => 'row-span-3'
        ], [
            'question' => 'Costs',
            'abbrev' => 'Costs',
            'description' => 'There is clear evidence of the costs necessary to launch and maintain this business model.',
            'color' => 'green-500',
            'section' => 'Viability_(Regulatory)',
            'order' => 10,
            'classes' => 'row-span-3'
        ],
    ],
    'qualitative-intuitive-scoring' => [
        [
            'question' => 'Team Performance',
            'description' => 'How confident are you that this team has the expertise, background and experience needed to continue to progress in the Business Model?',
            'color' => 'red-500',
            'section' => 'Intutive_Scoring',
            'order' => 10,
            'hidden' => true,
        ], [
            'question' => 'Team Gameplan',
            'description' => 'How confident are you the proposed gameplan for progression will meet the desired outcomes for the next sprint?',
            'color' => 'red-500',
            'section' => 'Intutive_Scoring',
            'hidden' => true,
        ]
    ],
    'qualitative-intuitive-scoring-feedback' => [
        [
            'question' => 'Overall Feedback',
            'description' => 'Your general thoughts, impressions, and feedback for the Team',
            'color' => '',
            'section' => 'feedback',
            'hidden' => true,
        ], [
            'question' => 'Specific Questions',
            'description' => 'Any specific areas you would like to see more information, or specific questions you have for this Team',
            'color' => '',
            'section' => 'feedback',
            'hidden' => true,
        ]
    ]

];

