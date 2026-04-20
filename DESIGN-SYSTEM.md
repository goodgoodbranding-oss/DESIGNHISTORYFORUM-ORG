# DESIGN HISTORY FORUM

## Purpose

This file turns the current Kadence-based homepage into a clearer design system so we can improve the site deliberately instead of "styling the starter template a bit more."

It is based on:

- the active Kadence theme export
- the current rebuilt homepage screenshot
- the original starter template screenshot

## Current diagnosis

The current homepage already has a promising atmosphere:

- strong orange accent
- architectural imagery
- lots of white space
- an editorial rather than corporate direction

What still feels too close to the starter template:

- the homepage structure is still mostly the original starter layout
- the hero composition is not distinctive enough yet
- typography has more personality now, but the hierarchy still needs to be tightened
- orange cards feel like builder modules instead of one coherent component family
- the lower half of the page loses rhythm and ends too softly

## Brand direction

We are aiming for:

- bold typography
- museum-editorial rhythm
- clean white space
- architectural calm with sharper contrast
- premium feel, not generic builder output

This means:

- fewer "default Kadence" proportions
- stronger heading scale
- more intentional image cropping
- more tension between text blocks and image blocks
- cleaner section transitions

## Core visual tokens

### Colors

- Accent: `#ff760a`
- Accent soft: `#ffe7d4`
- Main text: `#4a4a47`
- Heading / dark neutral: `#2d3748`
- Muted text: `#4a5568`
- Border: `#e3e3e3`
- Surface: `#ededed`
- Paper: `#ffffff`

### Typography

- Display / headings: `Bricolage Grotesque`
- Body / UI: `Inter`

### Typographic intent

- Headings should feel assertive, compressed, and curated
- Body text should stay readable and quiet
- Labels, meta text, and small captions should be consistent and understated
- CTA labels should feel designed, not default

## Homepage principles

### Hero

Direction:

- keep only the staircase image
- remove the second stacked image underneath
- make the hero feel more monumental and less like a premade split block

Rules:

- headline must dominate the left side
- image should feel tall, vertical, and architectural
- lead text should support the statement instead of competing with it
- CTA area should be more elegant and intentional

### Orange card row

Direction:

- keep the orange card idea
- redesign them as a real linked card system

Rules:

- all orange cards should link to `https://deepbrand.ing/` for now
- every card should be fully clickable
- hover should feel tactile: slight press, shadow shift, and faster response
- card spacing, height, and text alignment must be consistent

### Image and text sections

Direction:

- preserve the editorial asymmetry
- make each section feel composed rather than dropped into a builder grid

Rules:

- each image-text pairing should have a clear dominant side
- do not let all sections use the same proportions
- keep generous white space, but tighten dead zones
- use contrast in image scale to build rhythm down the page

### Lower homepage / ending

Direction:

- the homepage must end with intention
- contact and CTA should feel like a conclusion, not leftovers

Rules:

- stronger final CTA hierarchy
- cleaner footer transition
- more deliberate closing spacing

## Component language

### Buttons

- keep the current button family as the starting point
- avoid over-designing them
- improve polish through spacing, typography, and hover feedback

### Microinteractions

Allowed:

- subtle lift or press on hover
- soft shadow movement
- small underline or color shift on links
- smooth transitions around `180ms-240ms`

Avoid:

- large bounces
- flashy parallax
- generic "template" animation effects

## Spacing system

The current page has good air, but too many areas feel merely empty.

Target behavior:

- large sections should breathe
- internal spacing inside components should be tighter and more deliberate
- section rhythm should alternate between compressed and expanded moments
- homepage should read like an editorial story, not a stack of isolated rows

## What changes first

### Phase 1

- confirm Bricolage Grotesque is loaded correctly
- establish heading scale
- normalize lead text, labels, and small UI text
- clean spacing between homepage sections

### Phase 2

- rebuild hero composition
- keep staircase image only
- improve text-to-image balance
- refine CTA area

### Phase 3

- redesign orange cards as interactive linked components
- improve middle section rhythm
- refine image-text compositions

### Phase 4

- strengthen final CTA and footer ending
- carry the finished homepage language into the rest of the site

## Working rule for future changes

When we change the site, we should ask:

1. Does this make the page feel less like a starter template?
2. Does this strengthen hierarchy, rhythm, or clarity?
3. Does this match the museum-editorial direction?
4. Would this still look intentional if the content changed?

If the answer is "no" to most of these, we should not add it.
