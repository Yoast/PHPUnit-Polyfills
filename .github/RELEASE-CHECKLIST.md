Template to use for release PRs from `#.x` to `main`
===========================================================

Title: Release version x.x.x

<!--
If both a 1.x and a 2.x release are to be tagged, always tag the 1.x release first!
-->

## Functional
- [ ] Confirm that the most recent PHPUnit changelogs have been checked and that the library is still feature complete for those versions supported within the PHPUnit version constraints.
- [ ] Update the `VERSION` constant in the `phpunitpolyfills-autoload.php` file.
- [ ] Composer: check if any dependencies/version constraints need updating.

## Release
- [ ] Add changelog for the release - PR #xxx
    Verify that a release link at the bottom of the `CHANGELOG.md` file has been added.
- [ ] Merge this PR.
- [ ] Make sure all CI builds are green.
- [ ] Tag the release (careful, GH defaults to `2.x`!).
- [ ] Create a release from the tag (careful, GH defaults to `2.x`!) & copy & paste the changelog to it.
    Make sure to copy the links to the issues and the links to the GH usernames from the bottom of the changelog!
- [ ] Close the milestone.
- [ ] Open a new milestone for the next release.
- [ ] If any open PRs/issues which were milestoned for the release did not make it into the release, update their milestone.

## Announce
- [ ] Tweet about the release.


---

Additional actions to take, not part of the release checklist:
- [ ] Post a link to the release in the Yoast Slack.
- [ ] Update the dependency version constraints for WP Test Utils.
