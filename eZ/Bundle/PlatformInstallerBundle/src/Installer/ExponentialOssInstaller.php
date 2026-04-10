<?php

/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace EzSystems\PlatformInstallerBundle\Installer;

/**
 * Clean installer for the Exponential Platform OSS distribution.
 *
 * Provides the `exponential-oss` install type, distinct from the generic `clean`
 * type so that OSS-specific seed data, binaries or post-install steps can be
 * added here without touching the upstream clean installer.
 *
 * Currently delegates all work to CoreInstaller:
 *  - importSchema()    → SchemaBuilder (dynamic DDL, DBMS-agnostic, incl. SQLite)
 *  - importData()      → data/{dbms}/cleandata.sql  (incl. data/sqlite/cleandata.sql)
 *  - importBinaries()  → no-op
 *  - createConfiguration() → no-op
 */
class ExponentialOssInstaller extends CoreInstaller
{
}
