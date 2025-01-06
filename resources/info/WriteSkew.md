--- Write Skew Simulation ---

**Example**:  
Two transactions read the same data and make changes based on those reads, but since they don’t see each other’s changes, 
they both commit conflicting updates. This can lead to inconsistent or incorrect data.

- Transaction First reads the balance, which is $1,000.
- Transaction Second also reads the balance as $1,000, then sleeps for 5 seconds.
- Transaction First deducts $600, updates the balance to $400, and commits.
- After waking up, Transaction Second deducts $700, updates the balance to $300, and commits.
- In the end, Transaction Second overwrites the correct balance from Transaction First, leading to incorrect data.

### Write Skew in Different Isolation Levels

| Transaction Type | Write Skew Allowed   |
|------------------|----------------------|
| READ UNCOMMITTED | Yes                  |
| READ COMMITTED   | Yes                  |
| REPEATABLE READ  | Yes                  |
| SERIALIZABLE     | No                   |

