Release checklist
===========================================================

<!--
If releases for multiple branches are to be tagged, always tag the 1.x release first, 2.x second etc!
-->

## Functional
- [ ] Confirm that the most recent PHPUnit changelogs have been checked and that the library is still feature complete for those versions supported within the PHPUnit version constraints.
- [ ] Update the `VERSION` constant in the `phpunitpolyfills-autoload.php` file.
- [ ] Composer: check if any dependencies/version constraints need updating.

## Release
- [ ] Add changelog for the release - PR #xxx
    Verify that a release link at the bottom of the `CHANGELOG.md` file has been added.
- [ ] Merge the changelog PR.
- [ ] Make sure all CI builds are green.
- [ ] Tag the release on the 1.x branch (careful, GH defaults to `4.x`!).
- [ ] Create a release from the tag (careful, GH defaults to `4.x`!) & copy & paste the changelog to it.
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
