import { Releaser } from '@simple-release/core'
import { NpmProject } from '@simple-release/npm'

const CHANGELOG = 'CHANGELOG.md'

const releaser = new Releaser({
  project: new NpmProject({ changelogFile: CHANGELOG }),
  verbose: true,
})

await releaser.bump().run()

await releaser.commit().tag().run()
